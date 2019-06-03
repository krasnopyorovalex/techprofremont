<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalog_categories`.
 */
class m180208_065903_create_catalog_categories_table extends Migration
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

        $this->createTable('catalog_categories', [
            'id' => $this->primaryKey(),
            'catalog_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('{{%idx-catalog_categories-alias}}', '{{%catalog_categories}}', 'alias', true);

        $this->createIndex('idx-catalog_categories-parent_id', '{{%catalog_categories}}', 'parent_id');
        $this->createIndex('idx-catalog_categories-catalog_id', '{{%catalog_categories}}', 'catalog_id');

        $this->addForeignKey('fk-catalog_categories-parent', '{{%catalog_categories}}', 'parent_id', '{{%catalog_categories}}', 'id', 'SET NULL', 'RESTRICT');
        $this->addForeignKey('fk-catalog_categories-catalog', '{{%catalog_categories}}', 'catalog_id', '{{%catalog}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('catalog_categories');
    }
}
