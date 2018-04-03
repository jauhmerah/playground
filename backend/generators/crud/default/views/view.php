<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => Yii::t('app', '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>')]);
?>

<div>
    <?= '<?php' ?> $form = ActiveForm::begin(); ?>
    <?= '<?=' ?> \codetitan\widgets\ActionBar::widget([
        'template' => '{back} {edit} {delete}',
        'permissions' => ['edit' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update', 'delete' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-delete'],
    ]) ?>
    <?= '<?php' ?> ActiveForm::end(); ?>

    <?= '<?= ' ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
        ],
    ]) ?>
</div>
