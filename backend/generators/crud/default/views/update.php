<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = Yii::t('app', 'Update {modelClass}', ['modelClass' => Yii::t('app', '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>')]);
?>

<div>
    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
