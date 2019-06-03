<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\Catalog */
/* @var $catalog common\models\Catalog */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = $catalog->name;
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
                'template' => '{update} {sub-categories} {delete}',
                'buttons' => [
                    'update' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-pencil',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Редактировать запись'
                        ]), str_replace('catalog','category',$url));
                    },
                    'sub-categories' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-list2',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Перейти к подкатегориям'
                        ]), str_replace('catalog','category',$url));
                    },
                    'delete' => function($url){
                        return Html::a(Html::tag('i','',[
                            'class' => 'icon-trash',
                            'data-popup' => 'tooltip',
                            'data-original-title' => 'Удалить запись'
                        ]), str_replace('catalog','category',$url));
                    }
                ],
            ],
        ],
    ]);
    echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/category/add/".$catalog->id]), [
        'class' => 'btn bg-blue white'
    ]));?>
