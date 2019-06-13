<?php

namespace frontend\components;

use frontend\widgets\BrandsList\BrandsList;
use yii\base\Behavior;

/**
 * Class ParserBehavior
 * @package frontend\components
 */
class ParserBehavior extends Behavior
{
    /**
     * @param $model
     * @return mixed
     * @throws \Exception
     */
    public function parse($model)
    {
        if (false !== strpos($model->text, '{brands}')) {
            $model->text = str_replace('<p>{brands}</p>', BrandsList::widget(), $model->text);
        }

        return $model->text;
    }
}
