<?php

namespace common\models;

use backend\components\FileBehavior;
use backend\components\MakeListAutoBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $subdomain_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property int $phone
 * @property string $articul
 * @property string $balance
 * @property string $address
 * @property int $maker_id
 * @property string $image
 * @property string $advantages
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Catalog $category
 * @property Subdomains $subdomain
 * @property ProductsAutoVia[] $productsAutoVias
 * @property ProductsOriginalNumbers[] $productsOriginalNumbers
 * @property ProductsOriginalNumbers[] $productsOriginalNumbersValues
 * @property Makers $maker
 *
 * @mixin MakeListAutoBehavior
 */
class Products extends MainModel
{
    public const IMAGE_ENTITY = 'image';
    public const PATH = '/userfiles/products/';
    protected const ADVANTAGES = [
        'Выезд мастера',
        'Вызов курьера',
        'Срочный ремонт'
    ];

    public $file;
    public $bindingAutoList;
    public $originalNumbers;

    /**
     * @return array
     */
    public function behaviors(): array
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
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%products}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['category_id', 'name', 'alias', 'articul', 'maker_id'], 'required'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['articul', 'address'], 'string', 'max' => 128],
            [['balance'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 36],
            [['phone'], 'string', 'max' => 24],
            [['alias'], 'unique'],
            [['bindingAutoList', 'originalNumbers', 'advantages'], 'safe'],
            [['articul', 'address', 'balance', 'alias', 'name'], 'trim'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['subdomain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subdomains::class, 'targetAttribute' => ['subdomain_id' => 'id']],
            [['maker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Makers::class, 'targetAttribute' => ['maker_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'subdomain_id' => 'Субдомен',
            'name' => 'Наименование продукта',
            'text' => 'Текст',
            'alias' => 'Alias',
            'phone' => 'Телефон',
            'image' => 'Image',
            'file' => 'Изображение',
            'advantages' => 'Преимущества',
            'articul' => 'Артикул',
            'balance' => 'E-mail',
            'address' => 'Адрес',
            'bindingAutoList' => 'Выберите из списка модель, поколение',
            'originalNumbers' => 'Оригинальные номера',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'autoModelsValues' => 'Привязка товара к авто',
            'maker_id' => 'Производители',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(CatalogCategories::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getSubdomain(): ActiveQuery
    {
        return $this->hasOne(Subdomains::class, ['id' => 'subdomain_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductsOriginalNumbers(): ActiveQuery
    {
        return $this->hasMany(ProductsOriginalNumbers::class, ['product_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getProductsOriginalNumbersValues(): array
    {
        return $this->hasMany(ProductsOriginalNumbers::class, ['product_id' => 'id'])->select('number')->column();
    }

    /**
     * @return ActiveQuery
     */
    public function getProductsAutoVias(): ActiveQuery
    {
        return $this->hasMany(ProductsAutoVia::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMaker(): ActiveQuery
    {
        return $this->hasOne(Makers::class, ['id' => 'maker_id']);
    }

    /**
     * @return array
     */
    public function getAdvantages(): array
    {
        return self::ADVANTAGES;
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {

            $this->advantages = json_encode($this->advantages);

            return true;
        }
        return false;
    }

    public function afterFind(): void
    {
        parent::afterFind();

        $this->advantages = json_decode($this->advantages, false);

        if($this->productsAutoVias){
            $this->bindingAutoList = $this->transformListAutoSelectedAfterFind($this->productsAutoVias);
        }

        if ($this->productsOriginalNumbersValues){
            $this->originalNumbers = implode(',', $this->productsOriginalNumbersValues);
        }
    }

    public function afterSave($insert, $changedAttributes): void
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
