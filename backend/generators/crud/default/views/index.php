<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List {modelClass}', ['modelClass' => Yii::t('app', '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>')]);
$this->params['breadcrumbs'][] = Yii::t('app', '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>');
?>

<div>
    <?= '<?php' ?> $form = ActiveForm::begin(); ?>
    <?= '<?=' ?> \codetitan\widgets\ActionBar::widget([
        'target' => 'primary-grid',
        'template' => '{new} {edit} {delete}',
        'permissions' => ['new' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create', 'edit' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update', 'delete' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-delete'],
    ]) ?>
    <?= '<?php' ?> ActiveForm::end(); ?>

<?= $generator->enablePjax ? '<?php Pjax::begin(); ?>' : '' ?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= '<?php' ?> $output = GridView::widget([
        'id' => 'primary-grid',
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n" : ""; ?>
        'tableOptions' => ['class' => 'table table-striped table-condensed table-hover table-responsive'],
        'layout' => '{items}',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn', 
                'headerOptions' => ['class' => 'text-center', 'style' => 'width:25px'],
                'contentOptions' => ['class' => 'text-center'],
            ],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} {update}",
                'headerOptions' => ['style' => 'width:50px'],
                'contentOptions' => ['class' => 'text-center'],
                'visibleButtons' => [
                    'view' =>   \Yii::$app->user->can('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view'),
                    'update' => \Yii::$app->user->can('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update'),
                ],
            ],
        ],
    ]); ?>

    <?= '<?=' ?> \codetitan\widgets\GridNav::widget([
        'dataProvider' => $dataProvider,
        'output' => $output,
    ]) ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>
<?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
</div>
