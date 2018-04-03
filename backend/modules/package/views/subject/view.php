<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\package\models\Subject */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => Yii::t('app', 'Subject')]);
?>

<div>
    <?php $form = ActiveForm::begin(); ?>
    <?= \codetitan\widgets\ActionBar::widget([
        'template' => '{back} {edit} {delete}',
        'permissions' => ['edit' => 'package-update', 'delete' => 'package-delete'],
    ]) ?>
    <?php ActiveForm::end(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'code',
            'name',
            'created_at:datetime',
        ],
    ]) ?>
</div>
