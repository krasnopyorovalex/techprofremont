<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%products_auto_via}}`.
 */
class m190613_092535_drop_products_auto_via_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-products_auto_via-product', '{{%products_auto_via}}');

        $this->dropIndex('idx-products_auto_via-product_id', '{{%products_auto_via}}');

        $this->dropTable('{{%products_auto_via}}');
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
        $this->createTable('products_auto_via', [
            'product_id' => $this->integer()->notNull(),
            'type' => $this->string(512)->notNull(),
            'auto_id' => $this->integer()->notNull()
        ],$tableOptions);

        $this->addPrimaryKey('pk-products_auto_via', '{{%products_auto_via}}', ['product_id', 'auto_id']);

        $this->createIndex('idx-products_auto_via-product_id', '{{%products_auto_via}}', 'product_id');

        $this->addForeignKey('fk-products_auto_via-product', '{{%products_auto_via}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
    }
}
