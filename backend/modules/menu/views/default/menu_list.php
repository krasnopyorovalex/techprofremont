<?php
use backend\assets\MenuAsset;
use yii\helpers\Html;
use yii\helpers\Url;

MenuAsset::register($this);

/* @var $menu common\models\Menu */
/* @var $model common\models\MenuItems */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/menu'])];
$this->params['breadcrumbs'][] = $menu['name'];
?>

<?php if ($model):?>
    <div class="navigation_box">
        <?= $this->render('_list',[
            'model' => $model,
            'className' => 'navigation'
        ])?>
    </div>
<?php endif; ?>

<?php echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/menu/default/menu-items-add", 'id' => $menu['id']]), [
    'class' => 'btn bg-blue white'
]));?>
