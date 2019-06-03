<?php

namespace common\models;

use backend\components\FileBehavior;
use backend\components\MakeListAutoBehavior;
use yii\helpers\ArrayHelper;

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
class Products extends MainModel
{
    const PATH = '/userfiles/products/';
    const IMAGE_ENTITY = 'image';

    public $file;
    public $bindingAutoList;
    public $originalNumbers;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ],
            [
                'class' => MakeListAutoBehavior::class
            ]
        ]);
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'alias', 'articul', 'maker_id'], 'required'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['price', 'text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['articul'], 'string', 'max' => 128],
            [['barcode', 'balance'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['bindingAutoList', 'originalNumbers'], 'safe'],
            [['articul', 'barcode', 'balance', 'alias', 'name'], 'trim'],
            [['maker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Makers::class, 'targetAttribute' => ['maker_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Наименование продукта',
            'text' => 'Текст',
            'alias' => 'Alias',
            'price' => 'Телефон',
            'image' => 'Image',
            'file' => 'Изображение',
            'articul' => 'Артикул',
            'balance' => 'E-mail',
            'barcode' => 'Адрес',
            'bindingAutoList' => 'Выберите из списка модель, поколение',
            'originalNumbers' => 'Оригинальные номера',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'autoModelsValues' => 'Привязка товара к авто',
            'maker_id' => 'Производители',
        ];
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

    public function afterFind()
    {
        parent::afterFind();
        if($this->productsAutoVias){
            $this->bindingAutoList = $this->transformListAutoSelectedAfterFind($this->productsAutoVias);
        }
        if ($this->productsOriginalNumbersValues){
            $this->originalNumbers = implode(',', $this->productsOriginalNumbersValues);
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->unlinkAll('productsAutoVias', true);
        if($this->bindingAutoList){
            $autos = $this->transformListAutoSelectedToSave($this->bindingAutoList);
            array_map(function ($item) {
                $key = key($item);
                return (new ProductsAutoVia([
                    'product_id' => $this->id,
                    'type' => strval($key),
                    'auto_id' => intval($item[$key])
                ]))->save();
            }, $autos);
        }

        $this->unlinkAll('productsOriginalNumbers', true);
        if($this->originalNumbers){
            $this->originalNumbers = explode(',', $this->originalNumbers);
            array_map(function ($item) {
                return (new ProductsOriginalNumbers([
                    'product_id' => $this->id,
                    'number' => strval($item)
                ]))->save();
            }, $this->originalNumbers);
        }
    }
}
