<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_images}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $basename
 * @property string $ext
 * @property int $pos
 */
class ProductImages extends ActiveRecord
{
    const PATH = '/userfiles/product_images/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'basename', 'ext'], 'required'],
            [['product_id', 'pos'], 'integer'],
            [['basename'], 'string', 'max' => 32],
            [['ext'], 'string', 'max' => 5],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'basename' => 'Basename',
            'ext' => 'Ext',
            'pos' => 'Pos',
        ];
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return sprintf('%s', Yii::getAlias("/userfiles/product_images/{$this->product_id}/{$this->basename}.{$this->ext}"));
    }

    /**
     * @return string
     */
    public function getThumbPath(): string
    {
        return sprintf('%s', Yii::getAlias("/userfiles/product_images/{$this->product_id}/{$this->basename}_thumb.{$this->ext}"));
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $path = Yii::getAlias('@frontend/web'.self::PATH . $this->product_id . DIRECTORY_SEPARATOR);
            @unlink($path . $this->basename .'.'. $this->ext);
            @unlink($path . $this->basename .'_thumb.'. $this->ext);
            return true;
        }

        return false;
    }
}
