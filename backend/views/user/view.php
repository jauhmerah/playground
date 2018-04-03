<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => Yii::t('app', 'User')]);
?>

<div>
    <?php $form = ActiveForm::begin(); ?>
    <?= \codetitan\widgets\ActionBar::widget([
        'template' => '{back} {edit} {block} {unblock} {delete}',
        'permissions' => ['edit' => 'user-update', 'block' => 'user-update', 'unblock' => 'user-update', 'delete' => 'user-delete', 'resend_activation' => 'user-view'],
    ]) ?>
    <?php ActiveForm::end(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            'name',
            'is_disabled:boolean',
            'last_login_at:datetime',
            'created_at:datetime',
        ],
    ]) ?>
</div>
