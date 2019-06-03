<?php

namespace backend\modules\products;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * products module definition class
 */
class Products extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\products\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Продукция';
        // custom initialization code goes here
    }

    public function getModel()
    {
        return \common\models\Products::class;
    }
}
