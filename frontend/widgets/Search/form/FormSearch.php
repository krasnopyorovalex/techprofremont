<?php

namespace frontend\widgets\Search\form;

use common\models\Products;
use common\models\ProductsOriginalNumbers;

class FormSearch extends Products
{
    const TYPE_ARTICUL = 'articul';
    const TYPE_NAME = 'name';
    public $type;
    public $keyword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'keyword'], 'required'],
            ['type', 'in', 'range' => [self::TYPE_ARTICUL, self::TYPE_NAME]]
        ];
    }

    public function search($params)
    {
        $query = Products::find();

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
        }

        if($this->type == self::TYPE_NAME){
            $query->andFilterWhere([
                'name' => $this->keyword
            ]);
        } else {
            $ids = ProductsOriginalNumbers::find()->select('product_id')->where(['number' => $this->keyword])->column();

            $query->andFilterWhere([
                'id' => !empty($ids)
                    ? $ids
                    : [0]
            ]);
        }

        return $query->asArray()->all();
    }

}