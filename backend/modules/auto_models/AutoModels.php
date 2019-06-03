<?php

namespace backend\modules\auto_models;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * auto_models module definition class
 */
class AutoModels extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\auto_models\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Модели';
        // custom initialization code goes here
    }

    public function getModel()
    {
        return \common\models\AutoModels::class;
    }
}
