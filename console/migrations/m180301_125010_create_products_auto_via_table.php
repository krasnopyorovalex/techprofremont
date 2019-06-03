<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products_auto`.
 */
class m180301_125010_create_products_auto_via_table extends Migration
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
        $this->createTable('products_auto_via', [
            'product_id' => $this->integer()->notNull(),
            'type' => $this->string(512)->notNull(),
            'auto_id' => $this->integer()->notNull()
        ],$tableOptions);

        $this->addPrimaryKey('pk-products_auto_via', '{{%products_auto_via}}', ['product_id', 'auto_id']);

        $this->createIndex('idx-products_auto_via-product_id', '{{%products_auto_via}}', 'product_id');

        $this->addForeignKey('fk-products_auto_via-product', '{{%products_auto_via}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products_auto_via');
    }
}
