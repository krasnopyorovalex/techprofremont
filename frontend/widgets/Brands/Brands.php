<?php

namespace frontend\widgets\Brands;

use yii\base\Widget;

/**
 * Class Brands
 * @package frontend\widgets\Brands
 */
class Brands extends Widget
{
    /**
     * @var array
     */
    public $brands = [];

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->render('brands.twig', [
            'brands' => $this->brands
        ]);
    }
}
