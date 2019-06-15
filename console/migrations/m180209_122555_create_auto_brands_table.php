<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brands`.
 */
class m180209_122555_create_auto_brands_table extends Migration
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

        $this->createTable('brands', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'text' => $this->text(),
            'alias' => $this->string()->notNull(),
            'image' => $this->string(36)
        ],$tableOptions);

        $this->createIndex('{{%idx-brands-alias}}', '{{%brands}}', 'alias', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brands');
    }
}
