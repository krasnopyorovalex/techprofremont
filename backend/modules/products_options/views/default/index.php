<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\ProductsOptions */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = $this->context->module->params['name'];
?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => ['class' => 'table responsive'],
        'columns' => [
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url){
                        return Html::a(Html::tag('i','',['class' => 'icon-pencil']), $url);
                    },
                    'delete' => function($url){
                        return Html::a(Html::tag('i','',['class' => 'icon-trash']), $url);
                    }
                ],
            ],
        ],
    ]);
    echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/{$this->context->module->id}/add"]), [
        'class' => 'btn bg-blue white'
    ]));?>
