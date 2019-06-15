<?php

namespace common\models;

use common\models\Products as P;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%makers}}".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 *
 * @property ProductMakers[] $productMakers
 * @property Products[] $products
 */
class Makers extends ActiveRecord
{
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
    public function getProductMakers(): ActiveQuery
    {
        return $this->hasMany(ProductMakers::className(), ['maker_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(P::className(), ['id' => 'product_id'])->viaTable('{{%product_makers}}', ['maker_id' => 'id']);
    }
}
