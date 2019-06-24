<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_brands}}`.
 */
class m190620_123520_create_product_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%product_brands}}', [
            'product_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('pk-product_brands', '{{%product_brands}}', ['product_id', 'brand_id']);

        $this->addForeignKey('fk-product_brands-product', '{{%product_brands}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-product_brands-brand', '{{%product_brands}}', 'brand_id', '{{%brands}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_brands-product', '{{%product_brands}}');
        $this->dropForeignKey('fk-product_brands-brand', '{{%product_brands}}');

        $this->dropTable('{{%product_brands}}');
    }
}
