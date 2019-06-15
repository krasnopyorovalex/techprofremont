<?php

namespace frontend\widgets\Brands;

use common\models\Brands as Model;
use yii\base\Widget;

/**
 * Class Brands
 * @package frontend\widgets\Brands
 */
class Brands extends Widget
{

    /**
     * @return string
     */
    public function run(): string
    {
        $brands = Model::find()->asArray()->all();

        return $this->render('brands.twig', [
            'brands' => $brands
        ]);
    }
}
