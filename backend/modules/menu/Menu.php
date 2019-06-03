<?php

namespace backend\modules\menu;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * menu module definition class
 */
class Menu extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\menu\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Навигация';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Menu::class;
    }

}
