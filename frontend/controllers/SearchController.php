<?php

namespace frontend\controllers;

use core\services\SearchService;
use frontend\widgets\Search\form\FormSearch;

/**
 * Search controller
 */
class SearchController extends SiteController
{
    /**
     * @var SearchService
     */
    private $searchService;

    /**
     * SearchController constructor.
     * @param $id
     * @param $module
     * @param SearchService $searchService
     * @param array $config
     */
    public function __construct($id, $module, SearchService $searchService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->searchService = $searchService;
    }
    /**
     * @param string $alias
     * @return string
     */
    public function actionIndex($alias = 'search'): string
    {
        $searchModel = new FormSearch();
        $searchModel->load(\Yii::$app->request->queryParams);

        $products = $this->searchService->search($searchModel);

        return $this->render('search.twig',[
            'products' => $products
        ]);
    }
    
}
