<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\package\models\Subject */

$this->title = Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'Subject')]);
?>

<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
