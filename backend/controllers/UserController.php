<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use common\utilities\ActionHandler;
use common\models\User;
use backend\models\UserSearch;

/**
 * UserController implements the CRUD actions for User model.
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
                        'actions' => ['index', 'view'],
                        'roles' => ['user-view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['user-create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['user-update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['user-delete'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        ActionHandler::setReturnUrl();
        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($searchModel, [
                'block' => function ($model, $selections, $handler) {
                    $count = $handler->updateAll(['is_disabled' => 1], ['id' => $selections, 'is_deleted' => 0]);
                    if ($count) $handler->setFlash('success', $handler::t('{count} item blocked', ['count' => $count]).'.');
                },
                'unblock' => function ($model, $selections, $handler) {
                    $count = $handler->updateAll(['is_disabled' => 0], ['id' => $selections, 'is_deleted' => 0]);
                    if ($count) $handler->setFlash('success', $handler::t('{count} item unblocked', ['count' => $count]).'.');
                },
            ]);
            $actionHandler->execute();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($model, [
                'block' => function ($model, $selections, $handler) {
                    $count = $model::updateAll(['is_disabled' => 1], ['id' => $selections, 'is_deleted' => 0]);
                    if ($count) $handler->setFlash('success', $handler::t('{count} item blocked', ['count' => $count]).'.');
                },
                'unblock' => function ($model, $selections, $handler) {
                    $count = $model::updateAll(['is_disabled' => 0], ['id' => $selections, 'is_deleted' => 0]);
                    if ($count) $handler->setFlash('success', $handler::t('{count} item unblocked', ['count' => $count]).'.');
                },
            ]);
            $actionHandler->execute();
        
            // Refresh model information
            $model = $this->findModel($id);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario('create');

        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($model);
            $action = $actionHandler->execute();

            if ($action && $model->load(Yii::$app->request->post())) {
                $model->setPassword($model->password);
                $model->generateAuthKey();
                $model->image = \yii\web\UploadedFile::getInstance($model, 'image');

                if ($model->save()) {
                    $model->setRoles($model->role);
                    $model->saveImage();

                    $actionHandler->gotoReturnUrl($model);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');

        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($model);
            $action = $actionHandler->execute();

            if ($action && $model->load(Yii::$app->request->post())) {
                if ($model->password) $model->setPassword($model->password);
                $model->image = \yii\web\UploadedFile::getInstance($model, 'image');

                if ($model->save()) {
                    $model->setRoles($model->role);
                    $model->saveImage();

                    $actionHandler->gotoReturnUrl($model);
                }
            }
        } elseif (Yii::$app->request->isAjax && Yii::$app->request->post('actionRemoveImage')) {
            $model->avatar = null;
            $model->save(false);
            return true;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
