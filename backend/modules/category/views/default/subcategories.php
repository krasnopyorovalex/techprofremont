<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\SubCategory */
/* @var $catalog common\models\Catalog */
/* @var $category common\models\Category */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => Url::toRoute(['/catalog'])];
$this->params['breadcrumbs'][] = ['label' => $catalog->name, 'url' => Url::toRoute(['/catalog/categories/'.$catalog->id])];
$this->params['breadcrumbs'][] = $category->name;
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table responsive'],
        'columns' => [
            'name',
            'alias',
            [
                'header' => 'Обновлена',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->updated_at);
                },
            ],
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
                        ]), str_replace('category','subcategory',$url));
                    },
                    'products' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-list2',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Перейти к товарам'
                        ]), str_replace('category','subcategory',$url));
                    },
                    'delete' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-trash',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Удалить запись'
                        ]), str_replace('category','subcategory',$url));
                    }
                ],
            ],
        ],
    ]);
    echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/subcategory/add/".$category->id]), [
        'class' => 'btn bg-blue white'
    ]));?>
