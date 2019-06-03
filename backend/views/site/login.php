<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use backend\assets\AppAsset;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

AppAsset::register($this);
$this->title = 'Вход в административную панель';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= $this->title?></title>
    <?php $this->head() ?>
</head>
<body class="login-container">
<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Simple login form -->

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                            <h5 class="content-group">Вход в систему <small class="display-block">Введите ваши данные для идентификации</small></h5>
                        </div>
                        <?php if ($model->getErrors()): ?>
                            <p>Неправильно введены логин или пароль</p>
                        <?php endif; ?>
                        <div class="form-group has-feedback has-feedback-left">
                            <?= Html::activeInput('text', $model, 'username', ['class' => 'form-control', 'placeholder' => 'Username', 'autofocus' => true]) ?>
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'placeholder' => 'Password']) ?>
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>
                        <?= $form->field($model, 'rememberMe')->checkbox(['checked' => true, 'class' => 'hidden'])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Войти' .Html::tag('i','',['class' => 'icon-circle-right2 position-right']), ['class' => 'btn btn-primary btn-block']) ?>
                        </div>

                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>