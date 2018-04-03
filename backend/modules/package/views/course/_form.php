<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

\frontend\assets\AutoNumericAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\modules\package\models\Course */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
    $(document).ready(function() {
        $('#course-price').autoNumeric('init', {vMin:0, vMax:99999.99});
    });
", \yii\web\View::POS_END);
?>

<div>
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}\n{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?php if ($model->isNewRecord): ?>
        <?= \codetitan\widgets\ActionBar::widget([
            'template' => '{save} {save2close} {save2new} {cancel}',
            'permissions' => ['save' => 'package-create', 'save2close' => 'package-create', 'save2new' => 'package-create'],
        ]) ?>
    <?php else: ?>
        <?= \codetitan\widgets\ActionBar::widget([
            'template' => '{save} {save2close} {save2new} {close}',
            'permissions' => ['save' => 'package-update', 'save2close' => 'package-update', 'save2new' => 'package-update'],
        ]) ?>
    <?php endif; ?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>
</div>
