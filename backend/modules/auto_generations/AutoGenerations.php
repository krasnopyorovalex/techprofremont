<?php

namespace backend\modules\auto_generations;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * auto_generations module definition class
 */
class AutoGenerations extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\auto_generations\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Поколения';
    }

    public function getModel()
    {
        return \common\models\AutoGenerations::class;
    }
}
