<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalog`.
 */
class m180208_065902_create_catalog_table extends Migration
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

        $this->createTable('catalog', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36),
            'is_main' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createIndex('{{%idx-catalog-alias}}', '{{%catalog}}', 'alias', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('catalog');
    }
}
