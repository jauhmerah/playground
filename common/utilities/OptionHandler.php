<?php
namespace common\utilities;

use Yii;

class OptionHandler extends \codetitan\handlers\OptionHandler
{
    public static function populate($params = [])
    {
        $data = parent::populate($params);

        $data['user-role'] = [
            'super' => 'Super Admin',
            'admin' => 'Admin',
            'registered' => 'Registered',
        ];

        $data['yes-no'] = [
            1 => Yii::t('app', 'Yes'),
            0 => Yii::t('app', 'No'),
        ];

        return $data;
    }
}