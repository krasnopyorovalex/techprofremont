<?php
/* @var $this yii\web\View */
/* @var $model common\models\Subdomains */

use backend\assets\SingleEditorAsset;
use backend\assets\SelectAsset;
use backend\assets\CheckBoxAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

SingleEditorAsset::register($this);
SelectAsset::register($this);
CheckBoxAsset::register($this);

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
                        <li><a href="#cases" data-toggle="tab">Падежи</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'domain_name')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'address')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'phone')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'contact_text')->textarea([
                                        'id' => 'editor-full',
                                        'placeholder' => 'Введите текст...'
                                    ]) ?>
                                    <?= $form->field($model, 'is_main')->checkbox(['class' => 'control-primary'], false)->error(false) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>

                        <div class="tab-pane" id="cases">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($model->casesItems as $key => $value): ?>
                                        <?= $form->field($model, 'cases['.$key.']')->textInput([
                                                'autocomplete' => 'off',
                                                'value' => isset($model->cases[$key])
                                                    ? $model->cases[$key]
                                                    : ''
                                        ])->label($value) ?>
                                    <?php endforeach; ?>
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