<?php

namespace frontend\widgets\SidebarMenu;

use common\models\Catalog;
use Yii;
use yii\base\Widget;
use yii\db\ActiveQuery;

/**
 * Class SidebarMenu
 * @package frontend\widgets\SidebarMenu
 */
class SidebarMenu extends Widget
{
    public $model = [];
    public $catalogAlias = false;

    /**
     * @return string
     */
    public function run(): string
    {
        $request = Yii::$app->request;
        $this->catalogAlias = $this->catalogAlias ?: $request->get('catalog');

        if( ! $this->model) {
            $catalog = Catalog::find()->where(['is_main' => Catalog::IS_MAIN])->with(['catalogCategories' => static function(ActiveQuery $query){
                return $query->with(['brands']);
            }])->limit(1)->one();

            $this->model = $catalog['catalogCategories'];

            $this->catalogAlias = $catalog['alias'];
        }

        return $this->render('sidebar_menu.twig', [
            'model' => $this->reOrder(),
            'catalog' => $this->catalogAlias
        ]);
    }

    /**
     * @return array
     */
    private function reOrder(): array
    {
        $links = ['in'=> [],'roots' => []];

        if ($this->model) {
            foreach ($this->model as $item) {
                if( ! $item['parent_id'] ){
                    $links['roots'][] = [
                        'name' => $item['name'],
                        'alias' => $item['alias'],
                        'id' => $item['id']
                    ];
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
