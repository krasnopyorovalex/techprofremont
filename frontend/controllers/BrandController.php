<?php

namespace frontend\controllers;

use common\models\Brands;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/**
 * Class BrandController
 * @package frontend\controllers
 */
class BrandController extends CatalogController
{
    /**
     * @param $alias
     * @param int $page
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias, $page = 0): string
    {
        $brand = $brand = Brands::find()->where(['alias' => $alias])->with([
            'categories' => static function (ActiveQuery $query) {
                return $query->with(['products', 'productCategories']);
            }
        ])->limit(1)->one();

        if ( ! $brand) {
            return parent::actionShow($alias);
        }

        return $this->render('brand.twig',[
            'brand' => $brand
        ]);
    }
}
