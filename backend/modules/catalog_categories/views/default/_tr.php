<?php
/* @var $this yii\web\View */
/* @var $model common\models\Catalog */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<tr class="<?= isset($className) ? $className : ''?>">
    <td><?= $model['name'] ?></td>
    <td><?= $model['alias'] ?></td>
    <td class="centered"><?= ($model['parent_id'] && count($model['products'])) ? count($model['products']) : ''?></td>
    <td>
        <?= Html::a(Html::tag('i','',['class' => 'icon-pencil']), Url::toRoute(['default/update', 'id' => $model['id']]),[
            'rel' => 'tooltip',
            'data-original-title' => 'Редактировать'
        ]);?>
        <?php if($model['parent_id']):?>
        <?= Html::a(Html::tag('i','',['class' => 'icon-list2']), Url::toRoute(['default/list', 'id' => $model['id']]),[
            'rel' => 'tooltip',
            'data-original-title' => 'Перейти к списку товаров'
        ]);?>
        <?php endif;?>
        <?= Html::a(Html::tag('i','',['class' => 'icon-trash']), Url::toRoute(['default/delete', 'id' => $model['id']]),[
            'rel' => 'tooltip',
            'data-original-title' => 'Удалить'
        ]);?>
    </td>
</tr>
<?php if ($model['catalogCategories']): ?>
    <?php foreach ($model['catalogCategories'] as $child):?>
        <?= $this->render('_tr', ['model' => $child, 'className' => isset($className) ? $className.'_l' : ''])?>
    <?php endforeach;?>
<?php endif; ?>

