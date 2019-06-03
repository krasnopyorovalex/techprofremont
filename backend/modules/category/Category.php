<?php

namespace backend\modules\category;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * category module definition class
 */
class Category extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\category\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Категории';
        // custom initialization code goes here
    }

    public function getModel()
    {
        return \common\models\Category::class;
    }
}
