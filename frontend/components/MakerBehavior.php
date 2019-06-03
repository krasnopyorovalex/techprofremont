<?php

namespace frontend\components;

use yii\base\Behavior;

/**
 * Class MakerBehavior
 * @package frontend\components
 */
class MakerBehavior extends Behavior
{
    /**
     * @param array $items
     * @return array
     */
    public function getProducts(array $items): array
    {
        return array_map(function ($item) {
            return $item['products'];
        }, $items);
    }

}