<?php

namespace frontend\widgets\BrandsList;

use common\models\Brands;
use yii\base\Widget;

/**
 * Class BrandsList
 * @package frontend\widgets\SidebarMenu
 */
class BrandsList extends Widget
{
    /**
     * @return string
     */
    public function run(): string
    {
        $brands = Brands::find()->all();

        return $this->render('brands.twig', [
            'brands' => $brands
        ]);
    }
}
