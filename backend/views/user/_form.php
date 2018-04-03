<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

if ($model->avatar) {
    $model->image = 'images/avatars/'.$model->avatar;
}

$url['role'] = \yii\helpers\Url::to(['/option/user/role', 'exclude' => 'super']);
$initVal['role'] = [];
$model->role = $model->getRoles();
if ($model->role) {
    foreach ($model->role as $role) {
        $initVal['role'][] = \common\utilities\OptionHandler::resolve('user-role', $role);
    }
}

$url['country'] = \yii\helpers\Url::to(['/lookup/base/country', 'ref' => 'user-country', 'per-page' => 8]);
$initVal['country'] = null;
if ($model->country) {
    $initVal['country'] = \common\models\OptCountry::findOne($model->country)->name;
}
?>

<div>
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}\n{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?php if ($model->isNewRecord): ?>
        <?= \codetitan\widgets\ActionBar::widget([
            'template' => '{save} {save2close} {save2new} {cancel}',
            'permissions' => ['save' => 'user-create', 'save2close' => 'user-create', 'save2new' => 'user-create'],
        ]) ?>
    <?php else: ?>
        <?= \codetitan\widgets\ActionBar::widget([
            'template' => '{save} {save2close} {save2new} {close}',
            'permissions' => ['save' => 'user-update', 'save2close' => 'user-update', 'save2new' => 'user-update'],
        ]) ?>
    <?php endif; ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->widget(\codetitan\widgets\GeneratePasswordInput::classname()) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'role')->widget(Select2::classname(), [
            'initValueText' => $initVal['role'],
            'showToggleAll' => false,
            'pluginOptions' => [
                'multiple' => true,
                'maximumSelectionLength' => 2,
                'ajax' => [
                    'url' => $url['role'],
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {search:params.term}; }'),
                ],
            ],
        ]) ?>

        <div class="horizontal-divider" style="border-color:#ccc;"></div>

        <?= $form->field($model, 'image')->widget(\codetitan\widgets\ImageInput::classname()) ?>

        <?= $form->field($model, 'country')->widget(\codetitan\widgets\LookupInput::classname(), [
            'url' => $url['country'],
            'initValueText' => $initVal['country'],
            'height' => '400px',
        ]) ?>

    <?php ActiveForm::end(); ?>
</div>
