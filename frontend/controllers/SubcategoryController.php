<?php

namespace frontend\controllers;

use common\models\AutoBrands;
use common\models\Catalog;
use common\models\Products;
use common\models\SubCategory;
use yii\web\NotFoundHttpException;

/**
 * Subcategory controller
 */
class SubcategoryController extends SiteController
{

    /**
     * @param $catalog
     * @param $subcategory
     * @param int $page
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSubcategory($catalog, $subcategory, $page = 0)
    {
        if(!$model = SubCategory::find()->where(['alias' => $subcategory])->with(['category'])->asArray()->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model['catalog'] = Catalog::find()->where(['alias' => $catalog])->with(['categories' => function($query){
            return $query->with(['subCategories']);
        }])->one();

        $query = Products::find()->where(['subcategory_id' => $model['id']]);
        $count = $query->count();
        $products = $query->offset($page)
            ->limit(\Yii::$app->params['per_page'])
            ->all();

        $data = [
            'products' => $products,
            'count' => $count,
            'offset' => ($page + \Yii::$app->params['per_page'])
        ];

        if(\Yii::$app->request->isPost){
            $data['products'] = $this->renderAjax('@frontend/widgets/ProductsListForCategory/views/products_list_for_category.twig',[
                'model' => $data['products']
            ]);
            return $this->asJson($data);
        }

        return $this->render('page.twig',[
            'model' => $model,
            'products' => $data['products'],
            'count' => $data['count'],
            'offset' => $data['offset'],
            'brands' => AutoBrands::find()->asArray()->all()
        ]);
    }
}
