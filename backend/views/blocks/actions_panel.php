<?php
use yii\helpers\Html;
$action = $this->context->action->id;
?>
<?= Html::submitButton(($action == 'delete' || $action == 'delete-item' || $action == 'menu-items-delete') ? 'Удалить' : 'Сохранить', [
    'class' => ($action == 'delete' || $action == 'delete-item' || $action == 'menu-items-delete') ? 'btn btn-danger' :'btn btn-primary pull-left',
    'data-original-title' => ($action == 'delete' || $action == 'delete-item' || $action == 'menu-items-delete') ? 'Удалить и вернуться к списку' : 'Сохранить и вернуться к списку',
    'data-popup' => 'tooltip'
]) ?>