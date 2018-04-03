<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List {modelClass}', ['modelClass' => Yii::t('app', 'User')]);
$this->params['breadcrumbs'][] = Yii::t('app', 'User');
?>

<div>
    <?php $form = ActiveForm::begin(); ?>
    <?= \codetitan\widgets\ActionBar::widget([
        'target' => 'primary-grid',
        'template' => '{new} {edit} {block} {unblock} {delete}',
        'permissions' => ['new' => 'user-create', 'edit' => 'user-update', 'block' => 'user-update', 'unblock' => 'user-update', 'delete' => 'user-delete'],
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
            'email',
            'name',
            [
                'format' => 'datetime',
                'headerOptions' => ['style' => 'width:140px'],
                'attribute' => 'last_login_at',
            ],
            [
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center', 'style' => 'width:30px'],
                'value' => function ($model) {
                    $icons = [];
                    if ($model->is_disabled) {
                        $icons[] = '<i class="color-red glyphicon glyphicon-ban-circle" data-toggle="tooltip" title="'.Yii::t('app', 'Blocked').'"></i>';
                    }

                    return implode(' ', $icons);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} {update}",
                'headerOptions' => ['style' => 'width:50px'],
                'contentOptions' => ['class' => 'text-center'],
                'visibleButtons' => [
                    'view' =>   \Yii::$app->user->can('user-view'),
                    'update' => \Yii::$app->user->can('user-update'),
                ],
            ],
        ],
    ]); ?>

    <?= \codetitan\widgets\GridNav::widget([
        'dataProvider' => $dataProvider,
        'output' => $output,
    ]) ?>
</div>
