<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\Products */
/* @var $catalogCategory common\models\CatalogCategories */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => Url::toRoute(['/catalog'])];
$this->params['breadcrumbs'][] = ['label' => $catalogCategory->catalog->name, 'url' => Url::toRoute(['/catalog_categories/cat-list/'.$catalogCategory->catalog->id])];

if($catalogCategory->parent->parent){
    $this->params['breadcrumbs'][] = ['label' => $catalogCategory->parent->parent->name, 'url' => Url::toRoute(['/catalog_categories/cat-list/'.$catalogCategory->catalog->id])];
}

if($catalogCategory->parent){
    $this->params['breadcrumbs'][] = ['label' => $catalogCategory->parent->name, 'url' => Url::toRoute(['/catalog_categories/cat-list/'.$catalogCategory->catalog->id])];
}

$this->params['breadcrumbs'][] = $catalogCategory->name;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table responsive'],
    'columns' => [
        'name',
        'alias',
//        [
//            'header' => 'Обновлен',
//            'value' => function ($model) {
//                return Yii::$app->formatter->asDate($model->updated_at);
//            },
//        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
            'template' => '{update} {products} {delete}',
            'buttons' => [
                'update' => function($url){
                    return Html::a(Html::tag('i','',[
                        'class' => 'icon-pencil',
                        'data-popup' => 'tooltip',
                        'data-original-title' => 'Редактировать запись'
                    ]), str_replace('catalog_categories','products',$url));
                },
                'delete' => function($url){
                    return Html::a(Html::tag('i','',[
                        'class' => 'icon-trash',
                        'data-popup' => 'tooltip',
                        'data-original-title' => 'Удалить запись'
                    ]), str_replace('catalog_categories','products',$url));
                }
            ],
        ],
    ],
]);
echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/products/add/".$catalogCategory->id]), [
    'class' => 'btn bg-blue white'
]));?>