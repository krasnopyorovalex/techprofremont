<?php

namespace backend\modules\catalog;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * catalog module definition class
 */
class Catalog extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\catalog\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Каталог';
    }

    public function getModel()
    {
        return \common\models\Catalog::class;
    }
}
