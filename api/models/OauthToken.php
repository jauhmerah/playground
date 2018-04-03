<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "{{%oauth_token}}".
 *
 * @property string $access_token
 * @property integer $user_id
 * @property string $scope
 * @property integer $expire_at
 * @property integer $created_at
 */
class OauthToken extends \yii\db\ActiveRecord
{
    const ACCESS_LIFETIME = 3600;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth_token}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expire_at'], 'default', 'value' => new \yii\db\Expression('UNIX_TIMESTAMP() + '.static::ACCESS_LIFETIME)],

            [['access_token', 'user_id', 'expire_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['access_token'], 'string', 'max' => 64],
            [['scope'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'access_token' => Yii::t('app', 'Access Token'),
            'user_id' => Yii::t('app', 'User ID'),
            'scope' => Yii::t('app', 'Scope'),
            'expire_at' => Yii::t('app', 'Expire At'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'user_id'])
            ->onCondition(['{{%user}}.is_deleted' => 0]);
    }
}
