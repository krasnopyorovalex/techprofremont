<?php

namespace common\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%makers}}".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 *
 * @property MakerCatalogCategories[] $makerCatalogCategories
 * @property CatalogCategories[] $catalogCategories
 */
class Makers extends ActiveRecord
{
    public $bindingCategoriesList;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%makers}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'alias'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['bindingCategoriesList'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'alias' => 'Alias',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getMakerCatalogCategories(): ActiveQuery
    {
        return $this->hasMany(MakerCatalogCategories::className(), ['maker_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCatalogCategories(): ActiveQuery
    {
        return $this->hasMany(CatalogCategories::className(), ['id' => 'catalog_category_id'])->viaTable('{{%maker_catalog_categories}}', ['maker_id' => 'id']);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isChecked(int $id): bool
    {
        $keys = ArrayHelper::getColumn($this->makerCatalogCategories, 'catalog_category_id');

        return in_array($id, $keys, true);
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        $this->unlinkAll('catalogCategories', true);

        if ($this->bindingCategoriesList) {

            $keys = array_keys(array_filter($this->bindingCategoriesList));

            array_map(function ($item) {
                return (new MakerCatalogCategories([
                    'maker_id' => $this->id,
                    'catalog_category_id' => (int)$item
                ]))->save();
            }, $keys);
        }
    }
}
