<?php

namespace frontend\components;

use yii\base\Behavior;

/**
 * Class OriginalNumberBehavior
 * @package frontend\components
 */
class OriginalNumberBehavior extends Behavior
{
    /**
     * @param array $items
     * @return array
     */
    public function getProducts(array $items): array
    {
        return array_map(function ($item) {
            return $item['product'];
        }, $items);
    }

}