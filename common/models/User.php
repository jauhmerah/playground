<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $name
 * @property string $country
 * @property string $avatar
 * @property integer $is_disabled
 * @property integer $is_deleted
 * @property integer $last_login_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
//    const STATUS_PENDING = 0;
//    const STATUS_ACTIVE = 10;

    public $role;
    public $password, $password_retype;

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            \yii\behaviors\BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'name', 'role'], 'required'],
            [['auth_key'], 'required', 'except' => 'update'],

            [['is_disabled', 'is_deleted', 'last_login_at', 'created_at', 'updated_at', 'created_by', 'created_by'], 'integer'],
            [['email', 'password_hash', 'password_reset_token', 'name', 'avatar'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['country'], 'string', 'max' => 2],

//            ['status', 'default', 'value' => self::STATUS_ACTIVE],
//            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_PENDING]],

            [['email'], 'email', 'checkDNS' => true],
            [['email'], 'unique', 'filter' => 'is_deleted=0'],

            [['password', 'password_retype'], 'safe'],
            [['password'], 'required', 'on' => ['changePassword']],
            [['password'], 'string', 'length' => [6, 20]],
            [['password_retype'], 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'on' => ['changePassword']],

            [['image'], 'image', 
                'maxSize' => 5 * 1024 * 1024,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'name' => Yii::t('app', 'Name'),
            'country' => Yii::t('app', 'Country'),
            'avatar' => Yii::t('app', 'Avatar'),
            'is_disabled' => Yii::t('app', 'Blocked'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'last_login_at' => Yii::t('app', 'Last Login At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'is_deleted' => 0]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //'{{%user}}.status' => self::STATUS_ACTIVE
        $model = \api\models\OauthToken::find()->joinWith(['user'])->where(['access_token' => $token])->one(); 
        if ($model) return $model->user;
        else return false;
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'is_disabled' => 0, 'is_deleted' => 0]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'is_disabled' => 0,
            'is_deleted' => 0,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Update last login
     */
    public function saveLastLogin()
    {
        $this->last_login_at = new \yii\db\Expression('UNIX_TIMESTAMP()');
        $this->save(false);
    }

    public function getRoles()
    {
        return \codetitan\helpers\RbacHelper::getRoles($this->id);
    }

    public function hasRoles($criterias, $operator = 'OR')
    {
        return \codetitan\helpers\RbacHelper::hasRoles($this->id, $criterias, $operator);
    }

    public function setRoles($roles)
    {
        \codetitan\helpers\RbacHelper::setRoles($this->id, $roles);
    }

    public function saveImage()
    {
        if ($this->image) {
            $filename = $this->id.'.'.$this->image->extension;
            $this->image->saveAs(Yii::getAlias('@webroot/images/avatars/').$filename);

            $this->avatar = $filename;
            $this->save(false);
            return true;
        }

        return false;
    }
}
