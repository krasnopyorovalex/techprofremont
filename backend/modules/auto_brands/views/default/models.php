<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\Catalog */
/* @var $brand common\models\AutoBrands */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = $brand->name;
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table responsive'],
        'columns' => [
            'name',
            'alias',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{update} {generations} {delete}',
                'buttons' => [
                    'update' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-pencil',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Редактировать запись'
                        ]), str_replace('auto_brands','auto_models',$url));
                    },
                    'generations' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-list2',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Перейти к модификациям'
                        ]), str_replace('auto_brands','auto_models',$url));
                    },
                    'delete' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-trash',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Удалить запись'
                        ]), str_replace('auto_brands','auto_models',$url));
                    }
                ],
            ],
        ],
    ]);
    echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/auto_models/add/".$brand->id]), [
        'class' => 'btn bg-blue white'
    ]));?>
