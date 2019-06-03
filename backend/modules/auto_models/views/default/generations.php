<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\AutoGenerations */
/* @var $brand common\models\AutoBrands */
/* @var $model common\models\AutoModels */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => 'Бренды авто', 'url' => Url::toRoute(['/auto_brands'])];
$this->params['breadcrumbs'][] = ['label' => $brand->name, 'url' => Url::toRoute(['/auto_brands/models/'.$brand->id])];
$this->params['breadcrumbs'][] = $model->name;
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
                        ]), str_replace('auto_models','auto_generations',$url));
                    },
                    'delete' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-trash',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Удалить запись'
                        ]), str_replace('auto_models','auto_generations',$url));
                    }
                ],
            ],
        ],
    ]);
    echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/auto_generations/add/".$model->id]), [
        'class' => 'btn bg-blue white'
    ]));?>
