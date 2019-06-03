<?php

namespace backend\modules\auto_brands;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * auto_brands module definition class
 */
class AutoBrands extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\auto_brands\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Бренды авто';
        // custom initialization code goes here
    }

    public function getModel()
    {
        return \common\models\AutoBrands::class;
    }
}
