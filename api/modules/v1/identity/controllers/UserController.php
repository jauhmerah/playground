<?php

namespace api\modules\v1\identity\controllers;

use Yii;
use yii\data\ActiveDataProvider;

use api\modules\v1\identity\models\User;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'api\modules\v1\identity\models\User';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\filters\auth\HttpBearerAuth::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function ($action) {
            return new ActiveDataProvider([
                'query' => User::find()->where(['is_deleted' => 0, 'id' => Yii::$app->user->id]),
            ]);
        };

        $actions['view'] = null; // Disabled
        $actions['create'] = null; // Disabled
        $actions['update'] = null; // Disabled
        $actions['delete'] = null; // Disabled

        return $actions;
    }
}
