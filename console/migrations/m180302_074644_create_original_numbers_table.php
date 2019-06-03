<?php

use yii\db\Migration;

/**
 * Handles the creation of table `original_numbers`.
 */
class m180302_074644_create_original_numbers_table extends Migration
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
        $this->createTable('products_original_numbers', [
            'product_id' => $this->integer()->notNull(),
            'number' => $this->string(128)->notNull()
        ],$tableOptions);

        $this->createIndex('idx-products_original_numbers-product_id', '{{%products_original_numbers}}', 'product_id');

        $this->addForeignKey('fk-products_original_numbers-product', '{{%products_original_numbers}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products_original_numbers');
    }
}
