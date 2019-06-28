<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%maker_catalog_categories}}`.
 */
class m190628_052820_create_maker_catalog_categories_table extends Migration
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

        $this->createTable('{{%maker_catalog_categories}}', [
            'maker_id' => $this->integer()->notNull(),
            'catalog_category_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('pk-maker_catalog_categories', '{{%maker_catalog_categories}}', ['maker_id', 'catalog_category_id']);

        $this->addForeignKey('fk-maker_catalog_categories-product', '{{%maker_catalog_categories}}', 'maker_id', '{{%makers}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-maker_catalog_categories-catalog_category', '{{%maker_catalog_categories}}', 'catalog_category_id', '{{%catalog_categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-maker_catalog_categories-product', '{{%maker_catalog_categories}}');
        $this->dropForeignKey('fk-maker_catalog_categories-catalog_category', '{{%maker_catalog_categories}}');

        $this->dropTable('{{%maker_catalog_categories}}');
    }
}
