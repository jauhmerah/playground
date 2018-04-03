<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\lookup\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div>
    <?php $output = GridView::widget([
        'id' => 'primary-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-condensed table-hover table-responsive'],
        'layout' => '{items}',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn', 
                'headerOptions' => ['class' => 'text-center', 'style' => 'width:25px'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            'code',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{select}",
                'headerOptions' => ['style' => 'width:30px'],
                'contentOptions' => ['class' => 'text-center'],
                'buttons' => [
                    'select' => function ($url, $model) {
                        $options = [
                            'title' => Yii::t('app', 'Select'),
                            'aria-label' => Yii::t('app', 'Select'),
                            'data-pjax' => '0',
                            'target' => '_blank',
                            'onclick' => "parent.selectLookup('".Yii::$app->request->get('ref')."', '".$model->code."', '".$model->name."')",
                        ];
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', 'javascript:void(0)', $options);
                    },
                ],
            ],
        ],
    ]); ?>

    <?= \codetitan\widgets\GridNav::widget([
        'dataProvider' => $dataProvider,
        'output' => $output,
    ]) ?>
</div>
