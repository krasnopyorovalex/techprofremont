<?php

use yii\db\Migration;

/**
 * Handles the creation of table `auto_models`.
 */
class m180209_122715_create_auto_models_table extends Migration
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
        $this->createTable('auto_models', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36)
        ],$tableOptions);

        $this->createIndex('{{%idx-auto_models-brand_id}}', '{{%auto_models}}', 'brand_id');
        $this->createIndex('{{%idx-auto_models-alias}}', '{{%auto_models}}', 'alias', true);

        $this->addForeignKey('{{%fk-auto_models-brand_id}}', '{{%auto_models}}', 'brand_id', '{{%auto_brands}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auto_models');
    }
}
