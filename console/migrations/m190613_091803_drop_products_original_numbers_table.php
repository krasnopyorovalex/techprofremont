<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%products_original_numbers}}`.
 */
class m190613_091803_drop_products_original_numbers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-products_original_numbers-product', '{{%products_original_numbers}}');

        $this->dropIndex('idx-products_original_numbers-product_id', '{{%products_original_numbers}}');

        $this->dropTable('{{%products_original_numbers}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('products_original_numbers', [
            'product_id' => $this->integer()->notNull(),
            'number' => $this->string(128)->notNull()
        ],$tableOptions);

        $this->createIndex('idx-products_original_numbers-product_id', '{{%products_original_numbers}}', 'product_id');

        $this->addForeignKey('fk-products_original_numbers-product', '{{%products_original_numbers}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
    }
}
