<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Products;
use yii\web\NotFoundHttpException;

/**
 * Category controller
 */
class CategoryController extends AutoModelController
{

    /**
     * @param $catalog
     * @param $category
     * @param int $page
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCategory($catalog, $category, $page = 0)
    {
        if(!$model = Category::find()->where(['alias' => $category])->with(['catalog' => function($query){
            return $query->with(['categories' => function($query){
                return $query->with(['subCategories']);
            }]);
        }])->one()){
            return parent::actionCategory($catalog, $category, $page = 0);
        }

        $query = Products::find()->where(['subcategory_id' => $model->getIdsSubCategories()]);
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
            'offset' => $data['offset']
        ]);
    }
}
