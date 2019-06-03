<?php

namespace frontend\widgets\SidebarMenu;

use common\models\Catalog;
use yii\base\Widget;

class SidebarMenu extends Widget
{
    public $model = null;
    public $catalogAlias = null;

    public function run()
    {
        $request = \Yii::$app->request;
        $queryParams = $request->get('brand') ? '/auto-' . $request->get('brand') : '';
        $queryParams .= $request->get('model') ? '/' . $request->get('model') : '';
        $queryParams .= $request->get('generation') ? '/' . $request->get('generation') : '';
        $this->catalogAlias = $this->catalogAlias ?? $request->get('catalog');

        if( ! $this->model ) {
            $catalog = Catalog::find()->where(['is_main' => 1])->with(['catalogCategories'])->limit(1)->one();
            $this->model = $catalog['catalogCategories'];
            $this->catalogAlias = $catalog['alias'];
        }

        return $this->render('sidebar_menu.twig', [
            'model' => $this->reOrder(),
            'queryParams' => $queryParams,
            'catalog' => $this->catalogAlias
        ]);
    }

    private function reOrder()
    {
        $links = ['in'=> [],'roots' => []];
        
        if($this->model){
            foreach ($this->model as $item) {
                if( ! $item['parent_id'] ){
                    array_push($links['roots'], [
                        'name' => $item['name'],
                        'alias' => $item['alias'],
                        'id' => $item['id']
                    ]);
                    continue;
                }

                $links['in'][$item['parent_id']][] = [
                    'name' => $item['name'],
                    'alias' => $item['alias'],
                    'id' => $item['id']
                ];
            }
        }

        return $links;
    }
}
