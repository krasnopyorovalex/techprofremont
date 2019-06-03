<?php
/* @var $this yii\web\View */
/* @var $model common\models\Menu */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = $this->context->actions[$this->context->action->id];
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="panel panel-flat">

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']) ?>
                        <?= $form->field($model, 'sys_name')->textInput(['autocomplete' => 'off']) ?>
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