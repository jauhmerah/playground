<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\package\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List {modelClass}', ['modelClass' => Yii::t('app', 'Course')]);
$this->params['breadcrumbs'][] = Yii::t('app', 'Course');
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
                'format' => 'currency',
                'attribute' => 'price',
                'filter' => \codetitan\helpers\FilterRangeHelper::textInput($searchModel, 'price_from', 'price_to'),
            ],
            [
                'format' => 'date',
                'attribute' => 'created_at',
                'filter' => \codetitan\helpers\FilterRangeHelper::datePicker($searchModel, 'date_from', 'date_to', ['itemOptions' => ['format' => 'dd/mm/yyyy']]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{subject}",
                'headerOptions' => ['style' => 'width:120px'],
                'contentOptions' => ['class' => 'text-center'],
                'buttons' => [
                    'subject' => function ($url, $model) {
                        return Html::a('Manage Subject', ['/package/subject', 'ref' => $model->id]);
                    },
                ],
                'visibleButtons' => [
                    'subject' => \Yii::$app->user->can('package-update') && Yii::$app->settings->can('subject_enabled'),
                ],
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
