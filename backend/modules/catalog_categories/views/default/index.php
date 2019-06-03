<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\CatalogCategories */
/* @var $catalog common\models\Catalog */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => Url::toRoute(['/catalog'])];
$this->params['breadcrumbs'][] = $catalog->name;
?>

<div>
    <?= Html::beginTag('table',['class' => 'table table-bordered table-striped table-hover responsive'])?>
    <tr>
        <th>Название</th>
        <th>Alias</th>
        <th>Количество товаров</th>
        <th>Действия</th>
    </tr>
    <?php if ($dataProvider): ?>
        <?php foreach ($dataProvider as $dp): ?>
            <?= $this->render('_tr',['model' => $dp, 'className' => 'level'])?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?= Html::endTag('table')?>
</div>
<br />
<?= Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/{$this->context->module->id}/add?catalog_id=".$catalog->id]), [
    'class' => 'btn bg-blue white'
]));?>