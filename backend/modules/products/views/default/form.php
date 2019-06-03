<?php
/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $catalogCategory common\models\Catalog */
/* @var array $makers common\models\Makers */

use backend\assets\SingleEditorAsset;
use backend\assets\SelectBootstrapAsset;
use backend\assets\SelectAsset;
use backend\assets\TagsInputAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

SingleEditorAsset::register($this);
SelectBootstrapAsset::register($this);
TagsInputAsset::register($this);
SelectAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => Url::toRoute(['/catalog'])];

if($catalogCategory->parent->parent){
    $this->params['breadcrumbs'][] = ['label' => $catalogCategory->parent->parent->name, 'url' => Url::toRoute(['/catalog_categories/cat-list/'.$catalogCategory->catalog->id])];
}

if($catalogCategory->parent){
    $this->params['breadcrumbs'][] = ['label' => $catalogCategory->parent->name, 'url' => Url::toRoute(['/catalog_categories/cat-list/'.$catalogCategory->catalog->id])];
}

$this->params['breadcrumbs'][] = ['label' => $catalogCategory->name, 'url' => Url::toRoute(['/catalog_categories/cat-list/'.$catalogCategory->catalog->id])];

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
                        <li><a href="#options" data-toggle="tab">Атрибуты</a></li>
                        <li><a href="#auto_brands" data-toggle="tab">Привязка товара к авто</a></li>
                        <li><a href="#image" data-toggle="tab">Изображение</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-8">
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'id' => 'from__generate']) ?>
                                    <?= $form->field($model, 'alias', [
                                        'template' => '<div class="form-group">{label}<div class="input-group"><span class="input-group-addon"><i class="icon-pencil"></i></span>{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'form-control',
                                        'id' => 'to__generate'
                                    ]) ?>
                                    <?php if($model->isNewRecord):?>
                                        <?= Html::activeInput('hidden',$model,'category_id',['value' => $catalogCategory->id])?>
                                    <?php endif;?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'maker_id')->dropDownList($makers, [
                                                'prompt' => 'Не выбрано',
                                                'class' => 'select-search'
                                    ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'originalNumbers')->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'form-control tags-input',
                                        'value' => is_array($model->originalNumbers)
                                            ? implode(',', $model->originalNumbers)
                                            : $model->originalNumbers
                                    ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'text')->textarea([
                                        'id' => 'editor-full',
                                        'placeholder' => 'Введите текст...'
                                    ]) ?>
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
                                        </div><hr>
                                    <?php endif;?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'file')->fileInput(['accept' => 'image/*']) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>

                        <div class="tab-pane" id="options">
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'price')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'articul')->textInput(['autocomplete' => 'off']) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'barcode')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'balance')->textInput(['autocomplete' => 'off']) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>
                        <div class="tab-pane" id="auto_brands">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- product auto -->
                                        <?= $form->field($model,'bindingAutoList',[
                                                'options' => [
                                                        'class' => 'multi-select-full'
                                                ]
                                        ])->dropDownList($model->makeListAuto(),[
                                                'multiple' => 'multiple',
                                                'class' => 'multiselect-filtering'
                                        ])?>
                                    <!-- product auto -->
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