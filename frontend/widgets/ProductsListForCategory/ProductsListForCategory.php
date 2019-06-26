<?php

namespace frontend\widgets\ProductsListForCategory;

use yii\base\Widget;

class ProductsListForCategory extends Widget
{
    public $items;

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('products_list_for_category.twig', [
            'model' => $this->items
        ]);
    }
}
