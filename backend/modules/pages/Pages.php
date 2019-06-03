<?php

namespace backend\modules\pages;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * pages module definition class
 */
class Pages extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\pages\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Страницы';
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Pages::class;
    }
}
