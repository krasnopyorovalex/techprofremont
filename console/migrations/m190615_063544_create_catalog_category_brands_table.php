<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catalog_category_brands}}`.
 */
class m190615_063544_create_catalog_category_brands_table extends Migration
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

        $this->createTable('{{%catalog_category_brands}}', [
            'category_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('pk-catalog_category_brands', '{{%catalog_category_brands}}', ['category_id', 'brand_id']);

        $this->addForeignKey('fk-catalog_category_brands-brand', '{{%catalog_category_brands}}', 'brand_id', '{{%brands}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-catalog_category_brands-category', '{{%catalog_category_brands}}', 'category_id', '{{%catalog_categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-catalog_category_brands-brand', '{{%catalog_category_brands}}');
        $this->dropForeignKey('fk-catalog_category_brands-category', '{{%catalog_category_brands}}');

        $this->dropTable('{{%catalog_category_brands}}');
    }
}
