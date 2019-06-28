<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%maker_catalog_categories}}".
 *
 * @property int $maker_id
 * @property int $catalog_category_id
 *
 * @property CatalogCategories $catalogCategory
 * @property Makers $maker
 */
class MakerCatalogCategories extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%maker_catalog_categories}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['maker_id', 'catalog_category_id'], 'required'],
            [['maker_id', 'catalog_category_id'], 'integer'],
            [['maker_id', 'catalog_category_id'], 'unique', 'targetAttribute' => ['maker_id', 'catalog_category_id']],
            [['catalog_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategories::className(), 'targetAttribute' => ['catalog_category_id' => 'id']],
            [['maker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Makers::className(), 'targetAttribute' => ['maker_id' => 'id']],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCatalogCategory(): ActiveQuery
    {
        return $this->hasOne(CatalogCategories::className(), ['id' => 'catalog_category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMaker(): ActiveQuery
    {
        return $this->hasOne(Makers::className(), ['id' => 'maker_id']);
    }
}
