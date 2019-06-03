<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products`.
 */
class m180208_141533_create_products_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'maker_id' => $this->integer(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'price' => $this->integer()->notNull()->defaultValue(0),
            'articul' => $this->string(128),
            'balance' => $this->string(64),
            'barcode' => $this->string(64),
            'image' => $this->string(36),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-products-category_id}}', '{{%products}}', 'category_id');
        $this->createIndex('{{%idx-products-alias}}', '{{%products}}', 'alias', true);

        $this->addForeignKey('{{%fk-products-category_id}}', '{{%products}}', 'category_id', '{{%catalog_categories}}', 'id');
        $this->addForeignKey('{{%fk-products-maker_id}}', '{{%products}}', 'maker_id', '{{%makers}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products');
    }
}
