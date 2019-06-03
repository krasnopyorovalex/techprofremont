<?php
/* @var $this yii\web\View */
/* @var $model common\models\MenuItems */
/* @var $menu common\models\Menu */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\assets\SelectAsset;

SelectAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = ['label' => $menu['name'], 'url' => Url::toRoute(['/menu/default/menu-items', 'id' => $menu['id']])];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Добавление пункта меню' : 'Редактирование пункта меню';
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="panel panel-flat">

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'parent_id')->dropDownList($model->getTree(), [
                            'class' => 'select-search',
                            'data-width' => '100%',
                            'prompt' => 'Не выбрано'
                        ])?>
                        <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']) ?>
                        <?= $form->field($model, 'link')->dropDownList($model->createLinks(), [
                            'class' => 'select-search', 'data-width' => '100%'
                        ])?>
                        <?php if($model->isNewRecord):?>
                            <?= $form->field($model, 'menu_id')->hiddenInput(['value' => $menu['id']])->label(false) ?>
                        <?php endif;?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?= $this->render('@backend/views/blocks/actions_panel')?>
                    </div>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>