<?php

namespace backend\components;

use common\models\CatalogCategories;
use common\models\CatalogCategoryBrands;
use common\models\Products;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * Class ProductRecordCsv
 * @package backend\components
 */
class ProductRecordCsv
{
    private const KEYS = [
        'name' => 0,
        'address' => 1,
        'phone' => 2,
        'working_hours' => 3,
        'email' => 4,
        'categories' => 5
    ];

    /**
     * @var array
     */
    private $data;

    /**
     * @var int
     */
    private $subdomain;

    /**
     * ProductRecordCsv constructor.
     * @param array $data
     * @param int $subdomain
     */
    public function __construct(array $data, int $subdomain)
    {
        $this->data = array_values($data);
        $this->subdomain = $subdomain;
    }

    public function save(): void
    {
        $product = new Products();

        $product->subdomain_id = $this->subdomain;
        $product->name = $this->getValue('name');
        $product->alias = Inflector::slug($product->name);
        $product->address = $this->getValue('address');

        if (Products::find()->where(['alias' => $product->alias])->exists()) {
            $alias = $product->alias . Inflector::slug($product->address);
            $product->alias = $alias;
        }

        $product->phone = $this->getValue('phone');
        $product->working_hours = $this->getValue('working_hours');
        $product->text = '';

        /**
         * set categories for product
         */
        $this->setCategoriesForProduct($product, $this->getValue('categories'));

        /**
         * set brands for product
         */
        $this->setBrandsForProduct($product);

        $product->save();

        unset($product);
    }

    /**
     * @param $key
     * @return mixed
     */
    private function getValue($key)
    {
        $key = self::KEYS[$key];

        return $this->data[$key] ?? '';
    }

    /**
     *
     * @param Products $product
     * @param string $names
     */
    private function setCategoriesForProduct(Products $product, string $names): void
    {
        $categories = explode(',', $names);

        $firstCategory = array_shift($categories);

        $firstCategoryRecord = CatalogCategories::findOne(['name' => trim($firstCategory)]);

        if ($firstCategoryRecord) {
            $product->category = $firstCategoryRecord;
        }

        foreach ($categories as $category) {

            $findCategory = CatalogCategories::findOne(['name' => trim($category)]);

            if ($findCategory) {

                $product->bindingCategoriesList[$findCategory->id] = 1;

                if ($findCategory->parent) {
                    $product->bindingCategoriesList[$findCategory->parent->id] = 1;
                }
            }
        }
    }

    private function setBrandsForProduct(Products $product): void
    {
        $categories = ArrayHelper::merge($product->bindingCategoriesList, [$product->category_id => 1]);

        $brands = CatalogCategoryBrands::find()
            ->where(['category_id' => array_keys($categories)])
            ->asArray()
            ->indexBy('brand_id')
            ->column();

        if (count($brands)) {
            $product->bindingBrandsList = array_values($brands);
        }
    }
}
