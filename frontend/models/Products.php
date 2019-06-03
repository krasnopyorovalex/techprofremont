<?php

namespace frontend\models;

use backend\components\MakeListAutoBehavior;
use common\models\Catalog;
use common\models\CatalogCategories;
use common\models\Makers;
use common\models\ProductsAutoVia;
use common\models\ProductsOriginalNumbers;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property int $price
 * @property string $articul
 * @property string $balance
 * @property string $barcode
 * @property int $maker_id
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Catalog $category
 * @property ProductsAutoVia[] $productsAutoVias
 * @property ProductsOriginalNumbers[] $productsOriginalNumbers
 * @property ProductsOriginalNumbers[] $productsOriginalNumbersValues
 * @property Makers $maker
 *
 * @mixin MakeListAutoBehavior
 */
class Products extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CatalogCategories::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsOriginalNumbers()
    {
        return $this->hasMany(ProductsOriginalNumbers::class, ['product_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getProductsOriginalNumbersValues()
    {
        return $this->hasMany(ProductsOriginalNumbers::class, ['product_id' => 'id'])->select('number')->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsAutoVias()
    {
        return $this->hasMany(ProductsAutoVia::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaker()
    {
        return $this->hasOne(Makers::class, ['id' => 'maker_id']);
    }
}
