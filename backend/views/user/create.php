<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'User')]);
?>

<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
