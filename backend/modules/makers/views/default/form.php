<?php
/* @var $this yii\web\View */
/* @var $model common\models\Makers */
/* @var $catalogCategory common\models\CatalogCategories */

use backend\assets\SelectAsset;
use backend\assets\SingleEditorAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

SelectAsset::register($this);
SingleEditorAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
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
                        <li><a href="#cats" data-toggle="tab">Привязка к категориям</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'id' => 'from__generate']) ?>
                                    <?= $form->field($model, 'alias', [
                                        'template' => '<div class="form-group">{label}<div class="input-group"><span class="input-group-addon"><i class="icon-pencil"></i></span>{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'form-control',
                                        'id' => 'to__generate'
                                    ]) ?>
                                    <?= $form->field($model, 'text')->textarea([
                                        'id' => 'editor-full',
                                        'placeholder' => 'Введите текст...'
                                    ]) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>

                        <div class="tab-pane" id="cats">
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
                                                    'checked' =>  $model->isChecked($item['id']) ?: false
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
    </div>
</div>
