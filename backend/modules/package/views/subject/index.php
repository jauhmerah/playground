<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\package\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List {modelClass}', ['modelClass' => Yii::t('app', 'Subject')]);
$this->params['breadcrumbs'] = [
    ['label' => $parentModel->name, 'url' => \yii\helpers\Url::previous('package/course')],
    Yii::t('app', 'Subject'),
];
?>

<div>
    <?php $form = ActiveForm::begin(); ?>
    <?= \codetitan\widgets\ActionBar::widget([
        'target' => 'primary-grid',
        'template' => '{new} {edit} {delete}',
        'permissions' => ['new' => 'package-create', 'edit' => 'package-update', 'delete' => 'package-delete'],
    ]) ?>
    <?php ActiveForm::end(); ?>

    <?php $output = GridView::widget([
        'id' => 'primary-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-condensed table-hover table-responsive'],
        'layout' => '{items}',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn', 
                'headerOptions' => ['class' => 'text-center', 'style' => 'width:25px'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            'code',
            'name',
            [
                'format' => 'boolean',
                'headerOptions' => ['style' => 'width:140px'],
                'attribute' => 'is_deleted',
                'filter' => \common\utilities\OptionHandler::render('yes-no'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} {update}",
                'headerOptions' => ['style' => 'width:50px'],
                'contentOptions' => ['class' => 'text-center'],
                'visibleButtons' => [
                    'view' =>   \Yii::$app->user->can('package-view'),
                    'update' => \Yii::$app->user->can('package-update'),
                ],
            ],
        ],
    ]); ?>

    <?= \codetitan\widgets\GridNav::widget([
        'dataProvider' => $dataProvider,
        'output' => $output,
    ]) ?>
</div>
