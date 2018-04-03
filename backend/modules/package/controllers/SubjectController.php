<?php

namespace backend\modules\package\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use common\utilities\ActionHandler;
use backend\modules\package\models\Subject;
use backend\modules\package\models\SubjectSearch;

/**
 * SubjectController implements the CRUD actions for Subject model.
 */
class SubjectController extends Controller
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
                        'allow' => false,
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->settings->can('subject_enabled');
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['package-view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['package-create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['package-update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['package-delete'],
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
     * Lists all Subject models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($ref = Yii::$app->request->get('ref')) {
            \codetitan\handlers\DependentHandler::push('Subject', '\backend\modules\package\models\Course', [
                'id' => $ref, 'is_deleted' => 0,
            ], ['/package/course']);
        }
        $parentModel = \codetitan\handlers\DependentHandler::fetch('Subject');

        $searchModel = new SubjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $parentModel->id);

        ActionHandler::setReturnUrl();
        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($searchModel);
            $actionHandler->execute();
        }

        return $this->render('index', [
            'parentModel' => $parentModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subject model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($model);
            $actionHandler->execute();
        
            // Refresh model information
            $model = $this->findModel($id);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Subject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $parentModel = \codetitan\handlers\DependentHandler::fetch('Subject');

        $model = new Subject();

        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($model);
            $action = $actionHandler->execute();

            if ($action && $model->load(Yii::$app->request->post())) {
                $model->course_id = $parentModel->id;

                if ($model->save()) {
                    $actionHandler->gotoReturnUrl($model);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Subject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post('action')) {
            $actionHandler = new ActionHandler($model);
            $action = $actionHandler->execute();

            if ($action && $model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $actionHandler->gotoReturnUrl($model);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Subject model.
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
     * Finds the Subject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subject::findOne(['id' => $id, 'is_deleted' => 0])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
