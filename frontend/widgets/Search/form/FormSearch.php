<?php

namespace frontend\widgets\Search\form;

use common\models\Products;

/**
 * Class FormSearch
 * @package frontend\widgets\Search\form
 */
class FormSearch extends Products
{
    private const TYPE_ARTICUL = 'articul';
    private const TYPE_NAME = 'name';

    public $type;
    public $keyword;

    /**
     * @inheritdoc
     */
    public function rules(): array
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

        if ( ! $this->validate()) {
            $query->where('0=1');
        }

        if($this->type === self::TYPE_NAME){
            $query->andFilterWhere([
                'name' => $this->keyword
            ]);
        }

        return $query->asArray()->all();
    }

}
