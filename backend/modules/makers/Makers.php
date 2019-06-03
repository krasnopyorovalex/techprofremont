<?php

namespace backend\modules\makers;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * makers module definition class
 */
class Makers extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\makers\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Производители';
        // custom initialization code goes here
    }

    public function getModel()
    {
        return \common\models\Makers::class;
    }
}
