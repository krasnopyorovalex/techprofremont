<?php

namespace backend\modules\subcategory;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * sub_category module definition class
 */
class SubCategory extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\subcategory\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Подкатегории';
        // custom initialization code goes here
    }

    public function getModel()
    {
        return \common\models\SubCategory::class;
    }
}
