<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%auto_models}}`.
 */
class m190615_061458_drop_auto_models_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-auto_models-brand_id}}', '{{%auto_models}}');

        $this->dropIndex('{{%idx-auto_models-alias}}', '{{%auto_models}}');
        $this->dropIndex('{{%idx-auto_models-brand_id}}', '{{%auto_models}}');

        $this->dropTable('{{%auto_models}}');
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
        $this->createTable('auto_models', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36)
        ],$tableOptions);

        $this->createIndex('{{%idx-auto_models-brand_id}}', '{{%auto_models}}', 'brand_id');
        $this->createIndex('{{%idx-auto_models-alias}}', '{{%auto_models}}', 'alias', true);

        $this->addForeignKey('{{%fk-auto_models-brand_id}}', '{{%auto_models}}', 'brand_id', '{{%brands}}', 'id');

        $this->addColumn('auto_models', 'h1', $this->string(512)->after('name'));
    }
}
