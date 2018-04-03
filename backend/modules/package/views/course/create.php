<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\package\models\Course */

$this->title = Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'Course')]);
?>

<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
