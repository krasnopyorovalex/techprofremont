<?php
/* @var $this yii\web\View */
/* @var $model common\models\CatalogCategories */
/* @var $catalog common\models\Catalog */

use backend\assets\SingleEditorAsset;
use backend\assets\SelectAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

SingleEditorAsset::register($this);
SelectAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => Url::toRoute(['/catalog'])];
$this->params['breadcrumbs'][] = ['label' => $catalog->name, 'url' => Url::toRoute(['/catalog_categories/cat-list/'.$catalog->id])];
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
                                <div class="col-md-8">
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'id' => 'from__generate']) ?>
                                    <?= $form->field($model, 'h1')->textInput() ?>
                                    <?php if($model->isNewRecord):?>
                                        <?= Html::activeInput('hidden',$model,'catalog_id',['value' => Yii::$app->request->get('catalog_id')])?>
                                    <?php endif;?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'alias', [
                                        'template' => '<div class="form-group">{label}<div class="input-group"><span class="input-group-addon"><i class="icon-pencil"></i></span>{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'form-control',
                                        'id' => 'to__generate'
                                    ]) ?>
                                    <?= $form->field($model, 'parent_id')->dropDownList($model->getTree(), [
                                        'class' => 'select-search',
                                        'data-width' => '100%',
                                        'prompt' => 'Не выбрано'
                                    ])?>
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