<?php
/* @var $this yii\web\View */
/* @var $model common\models\Products */
/* @var array $subdomains common\models\Subdomains */

use backend\assets\SelectBootstrapAsset;
use backend\assets\SelectAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

SelectBootstrapAsset::register($this);
SelectAsset::register($this);

$this->params['breadcrumbs'][] = $this->context->module->params['name'];
?>
<div class="row">
    <div class="col-md-12">
        <?php if(Yii::$app->session->hasFlash('info')):?>
            <div class="info">
                <?= Yii::$app->session->getFlash('info')?>
            </div>
        <?php endif; ?>
        <?php $form = ActiveForm::begin(['method' => 'post', 'action' => Url::toRoute(["/parser_csv/upload"]), 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'subdomain')->dropDownList($subdomains, [
            'class' => 'select-search'
        ]) ?>

        <?= $form->field($model, 'file')->fileInput(['accept' => '.csv']) ?>

        <?= Html::submitButton('Начать парсинг', [
            'class' => 'btn btn-primary pull-left'
        ]) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
