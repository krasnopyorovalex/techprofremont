<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%subdomains}}".
 *
 * @property int $id
 * @property string $domain_name
 * @property string $phone
 * @property string $address
 * @property string $contact_text
 * @property string $cases_json
 * @property int $is_main
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Products[] $products
 */
class Subdomains extends MainModel
{
    public const IS_MAIN = 1;

    public $casesItems = [
        'nominative' => 'Именительный(кто, что?)',
        'genitive' => 'Родительный(кого, чего?)',
        'dative' => 'Дательный(кому, чему?)',
        'accusative' => 'Винительный(кого, что?)',
        'ablative' => 'Творительный(кем, чем?)',
        'proposed' => 'Предложный(о ком, о чём?)'
    ];
    public $cases = [];

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%subdomains}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['domain_name', 'phone', 'address'], 'required'],
            [['contact_text', 'cases_json'], 'string'],
            [['is_main','created_at', 'updated_at'], 'integer'],
            [['domain_name'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 512],
            [['domain_name', 'phone', 'address'], 'trim'],
            ['cases', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'domain_name' => 'Url поддомена',
            'phone' => 'Телефон',
            'address' => 'Адрес',
            'contact_text' => 'Контактная информация',
            'cases_json' => 'Падежи',
            'is_main' => 'Основной сайт?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Products::class, ['subdomain_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->cases = Json::decode($this->cases_json);
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->cases_json = Json::encode($this->cases);
            return true;
        }
        return false;
    }
}
