<?php

namespace backend\modules\catalog_categories;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * catalog_categories module definition class
 */
class CatalogCategories extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\catalog_categories\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Категории';
    }

    public function getModel()
    {
        return \common\models\CatalogCategories::class;
    }
}
