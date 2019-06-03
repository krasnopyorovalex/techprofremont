<?php
use yii\helpers\Html;
?>
<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">

        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="/_root/dashboard/assets/images/placeholder.jpg" alt="">
                    <span><?= Yii::$app->user->identity->username?></span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="divider"></li>
                    <li>
                        <?= Html::a(Html::tag('i','',['class' => 'icon-switch2']).'Выйти', \yii\helpers\Url::toRoute('/site/logout'),[
                            'data-method' => 'post',
                        ])?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->