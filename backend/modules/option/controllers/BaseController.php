<?php
namespace backend\modules\option\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\models\OptCountry;

/**
 * Base controller
 */
class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * Return country list
     */
    public function actionCountry($search = null, $page = 1)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $perPage = 20;
        $output['results'] = [];

        $query = OptCountry::find()->orderBy(['name' => SORT_ASC]);
        if (!is_null($search)) {
            $query->where(['like', 'name', $search.'%', false]);
        }

        $output['total'] = $query->count('code');
        $results = $query->limit($perPage)->offset(($page-1) * $perPage)->all();
        foreach ($results as $result) {
            $output['results'][] = ['id' => $result->code, 'text' => $result->name];
        }

        return $output;
    }
}