<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_categories}}`.
 */
class m190613_121459_create_product_categories_table extends Migration
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

        $this->createTable('{{%product_categories}}', [
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('pk-product_categories', '{{%product_categories}}', ['product_id', 'category_id']);

        $this->addForeignKey('fk-product_categories-product', '{{%product_categories}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-product_categories-category', '{{%product_categories}}', 'category_id', '{{%catalog_categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_categories-product', '{{%product_categories}}');
        $this->dropForeignKey('fk-product_categories-category', '{{%product_categories}}');

        $this->dropTable('{{%product_categories}}');
    }
}
