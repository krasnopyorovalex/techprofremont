<?php
/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var $catalogCategory common\models\CatalogCategories */
/* @var array $brands common\models\Brands */
/* @var array $subdomains common\models\Subdomains */

use backend\assets\CheckboxListAsset;
use backend\assets\FileUploaderAsset;
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
CheckboxListAsset::register($this);
FileUploaderAsset::register($this);

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
                        <li><a href="#image" data-toggle="tab">Изображение</a></li>
                        <li><a href="#brands" data-toggle="tab">Бренды</a></li>
                        <li><a href="#dop_cats" data-toggle="tab">Дополнительные категории</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-8">
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'id' => 'from__generate']) ?>
                                    <?= $form->field($model, 'advantages')->dropDownList($model->getAdvantages(), [
                                        'prompt' => 'Не выбрано',
                                        'class' => 'select-search',
                                        'multiple' => true
                                    ]) ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'subdomain_id')->dropDownList($subdomains, [
                                        'class' => 'select-search'
                                    ]) ?>
                                    <?= $form->field($model, 'alias', [
                                        'template' => '<div class="form-group">{label}<div class="input-group"><span class="input-group-addon"><i class="icon-pencil"></i></span>{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'form-control',
                                        'id' => 'to__generate'
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
                                    <?= $form->field($model, 'phone')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'working_hours')->textInput(['autocomplete' => 'off']) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'address')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'balance')->textInput(['autocomplete' => 'off']) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>
                        <div class="tab-pane" id="brands">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox_list brands">
                                        <?php foreach ($brands as $item):?>
                                            <?= $form->field($model, 'bindingBrandsList['.$item->id.']')
                                                ->checkbox([
                                                    'checked' => $model->isCheckedBrand($item->id)
                                                ])
                                                ->label($item->name)
                                            ?>
                                        <?php endforeach;?>
                                    </div>
                                    <!-- /.checkbox_list -->
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>
                        <div class="tab-pane" id="dop_cats">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkbox_list">
                                        <?php foreach ($catalogCategory->getTree() as $item):?>
                                            <?php $cssClass = $item['class'] . ' '. $item['parent'];?>
                                            <?= $form->field($model, 'bindingCategoriesList['.$item['id'].']', [
                                                    'options' => [
                                                        'class' => $cssClass,
                                                        'data' => ['key' => $item['id']]
                                                    ]
                                                ])
                                                ->checkbox([
                                                    'checked' => $model->isMainCategory($item['id']) ?: $model->isChecked($item['id']) ?: false,
                                                    'class' => '',
                                                    'disabled' => $model->isMainCategory($item['id'])
                                                ])
                                                ->label($item['name'])
                                            ?>
                                        <?php endforeach;?>
                                    </div>
                                    <!-- /.checkbox_list -->
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>

        <?php if(! $model->isNewRecord):?>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'filesGallery')->fileInput([
                        'multiple' => 'multiple',
                        'class' => 'file-input-ajax',
                        'accept' => "image/*"
                    ])->label(false) ?>
                </div>
            </div>
            <div class="row" id="_images_box">
                <div class="col-md-12">
                    <?= $this->render('_images_box',[
                        'model' => $model
                    ])?>
                </div>
            </div>
            <hr>
        <?php endif;?>
    </div>
</div>
