<?php

namespace backend\modules\subdomains;

use yii\base\Module;
use backend\interfaces\ModelProviderInterface;

/**
 * subdomains module definition class
 */
class Subdomains extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\subdomains\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Поддомены';
    }

    public function getModel()
    {
        return \common\models\Subdomains::class;
    }
}
