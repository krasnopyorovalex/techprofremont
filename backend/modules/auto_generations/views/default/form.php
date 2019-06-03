<?php

/* @var $this yii\web\View */
/* @var $auto_model common\models\AutoModels */
/* @var $model common\models\AutoGenerations */

use backend\assets\SingleEditorAsset;
use backend\assets\SelectAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

SingleEditorAsset::register($this);
SelectAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Бренды авто', 'url' => Url::toRoute(['/auto_brands'])];
$this->params['breadcrumbs'][] = ['label' => $auto_model->brand->name, 'url' => Url::toRoute(['/auto_brands/models/'.$auto_model->brand->id])];
$this->params['breadcrumbs'][] = ['label' => $auto_model->name, 'url' => Url::to(Url::previous())];
$this->params['breadcrumbs'][] = $this->context->actions[$this->context->action->id];
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="panel panel-flat">

            <div class="panel-body">

                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#main" data-toggle="tab">Основное</a></li>
                        <li><a href="#image" data-toggle="tab">Изображение</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'id' => 'from__generate']) ?>
                                    <?= $form->field($model, 'h1')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'alias', [
                                        'template' => '<div class="form-group">{label}<div class="input-group"><span class="input-group-addon"><i class="icon-pencil"></i></span>{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'form-control',
                                        'id' => 'to__generate'
                                    ]) ?>
                                    <?php if($model->isNewRecord):?>
                                        <?= Html::activeInput('hidden',$model,'model_id',['value' => $auto_model->id])?>
                                    <?php endif;?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>

                        <div class="tab-pane" id="image">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if($model->image):?>
                                        <div class="thumbnail-single">
                                            <?= Html::img($model::PATH.$model->image)?>
                                            <?= Html::button(Html::tag('b','', ['class' => 'icon-trash']) . 'Удалить',[
                                                'class' => 'btn btn-danger btn-labeled btn-sm remove_image'
                                            ])?>
                                        </div>
                                    <?php endif;?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <?= $form->field($model, 'file')->fileInput(['accept' => 'image/*']) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>

                    </div>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>