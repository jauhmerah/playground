<?php
namespace backend\modules\option\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\models\User;

/**
 * User controller
 */
class UserController extends Controller
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
     * Return user list
     */
    public function actionIndex($search = null, $page = 1, $roles = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $perPage = 20;
        $output['results'] = [];

        $query = User::find()->where(['is_deleted' => 0])->orderBy(['name' => SORT_ASC]);
        if (!is_null($search)) {
            $query->andWhere(['like', 'name', $search]);
        }

        // Return user with role
        if ($roles) {
            $arr = explode(',', $roles);
            $query->join('LEFT JOIN', '{{%auth_assignment}}', '{{%auth_assignment}}.user_id = id')->groupBy('id')
                ->andWhere(['{{%auth_assignment}}.item_name' => $arr]);
        }

        $output['total'] = $query->count('id');
        $results = $query->limit($perPage)->offset(($page-1) * $perPage)->all();
        foreach ($results as $result) {
            $output['results'][] = ['id' => $result->id, 'text' => $result->name];
        }

        return $output;
    }

    /**
     * Return user role list
     */
    public function actionRole($search = null, $exclude = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $output = ['more' => false];
        $output['results'] = [];

        $options = ArrayHelper::getColumn(Yii::$app->authManager->getRoles(), 'name');
        $options = array_map(function ($val) {
            return \common\utilities\OptionHandler::resolve('user-role', $val);
        }, $options);

        if (!is_null($search)) $results = preg_grep('/'.$search.'/i', $options);
        else $results = $options;

        foreach ($results as $key => $val) {
            if ($key != $exclude) $output['results'][] = ['id' => $key, 'text' => $val];
        }

        return $output;
    }
}