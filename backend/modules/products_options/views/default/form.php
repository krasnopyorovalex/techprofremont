<?php
/* @var $this yii\web\View */
/* @var $model common\models\ProductsOptions */

use backend\assets\SingleEditorAsset;
use backend\assets\SelectAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

SingleEditorAsset::register($this);
SelectAsset::register($this);

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
                    </div>
                </div>

                <?= $this->render('@backend/views/blocks/actions_panel')?>

            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>