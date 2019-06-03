<?php

namespace backend\modules\products_options;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * products_options module definition class
 */
class ProductOptions extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\products_options\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Атрибуты продукции';
        // custom initialization code goes here
    }

    public function getModel()
    {
        return \common\models\ProductsOptions::class;
    }
}
