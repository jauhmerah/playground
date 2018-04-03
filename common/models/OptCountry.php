<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%opt_country}}".
 *
 * @property string $code
 * @property string $name
 * @property integer $phone_code
 */
class OptCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%opt_country}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'phone_code'], 'required'],
            [['phone_code'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'phone_code' => Yii::t('app', 'Phone Code'),
        ];
    }
}
