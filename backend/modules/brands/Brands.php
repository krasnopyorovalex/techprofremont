<?php

namespace backend\modules\brands;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * Class Brands
 * @package backend\modules\brands
 *
 * @property string $model
 */
class Brands extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\brands\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Бренды';
        // custom initialization code goes here
    }

    public function getModel(): string
    {
        return \common\models\Brands::class;
    }
}
