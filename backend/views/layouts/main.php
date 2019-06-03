<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Административная панель - <?= Yii::$app->request->serverName?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $this->render('@app/views/blocks/main_nav')?>

<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main">
            <div class="sidebar-content">

                <!-- Main navigation -->
                <div class="sidebar-category sidebar-category-visible">
                    <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">

                            <!-- Main -->
                            <li class="navigation-header"><span>Навигация</span> <i class="icon-menu" title="Навигация"></i></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/pages/default/index'])?>"><i class="icon-compose"></i> <span>Страницы</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/menu/default/index'])?>"><i class="icon-lan2"></i> <span>Навигация</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/subdomains/default/index'])?>"><i class="icon-earth"></i> <span>Поддомены</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/catalog/default/index'])?>"><i class="icon-folder5"></i> <span>Каталог</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/auto_brands/default/index'])?>"><i class="icon-car"></i> <span>Авто</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/makers/default/index'])?>"><i class="icon-make-group"></i> <span>Производители</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /main navigation -->

            </div>
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-default">

                <div class="breadcrumb-line">
                    <?= Breadcrumbs::widget([
                        'itemTemplate' => '<li>{link}</li>',
                        'activeItemTemplate' => '<li class="active">{link}</li>',
                        'options' => ['class' => 'breadcrumb'],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'homeLink' => [
                            'label' => 'Домой',
                            'url' => Yii::$app->homeUrl,
                            'template' => '<li><i class="icon-home2 position-left"></i>{link}</li>',
                        ]
                    ]) ?>
                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">

                <!-- Dashboard content -->
                    <?= Alert::widget() ?>
                    <?= $content ?>
                <!-- /dashboard content -->

                <!-- Footer -->
                <div class="footer text-muted">
                    &copy; ООО «Красбер» 2017 - <?= date('Y')?>
                </div>
                <!-- /footer -->

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
