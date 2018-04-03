<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div>
    <?= '<?php' ?> $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}\n{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

    <?= '<?php' ?> if ($model->isNewRecord): ?>
        <?= '<?=' ?> \codetitan\widgets\ActionBar::widget([
            'template' => '{save} {save2close} {save2new} {cancel}',
            'permissions' => ['save' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create', 'save2close' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create', 'save2new' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create'],
        ]) ?>
    <?= '<?php' ?> else: ?>
        <?= '<?=' ?> \codetitan\widgets\ActionBar::widget([
            'template' => '{save} {save2close} {save2new} {close}',
            'permissions' => ['save' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update', 'save2close' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update', 'save2new' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update'],
        ]) ?>
    <?= '<?php' ?> endif; ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>

    <?= '<?php' ?> ActiveForm::end(); ?>
</div>
