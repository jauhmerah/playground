<?php

namespace api\modules\v1\identity\models;

use Yii;

/**
 * User model
 */
class User extends \common\models\User
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['name'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token'], $fields['is_deleted']);

        return $fields;
    }
}
