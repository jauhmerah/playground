<?php

namespace backend\models;

use Yii;

/**
 * SettingForm is the model behind the settings form.
 */
class SettingForm extends \yii\base\Model
{
    public $subject_enabled;
    public $matrix_no_format;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject_enabled'], 'integer'],
            [['matrix_no_format'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subject_enabled' => Yii::t('app', 'Subject'),
            'matrix_no_format' => Yii::t('app', 'Matrix No. Format'),
        ];
    }
}
