<?php

namespace frontend\widgets\BrandsList;

use common\models\AutoBrands;
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
        $brands = AutoBrands::find()->all();

        return $this->render('brands.twig', [
            'brands' => $brands
        ]);
    }
}
