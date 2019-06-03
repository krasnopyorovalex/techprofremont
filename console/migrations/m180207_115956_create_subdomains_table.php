<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subdomains`.
 */
class m180207_115956_create_subdomains_table extends Migration
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

        $this->createTable('subdomains', [
            'id' => $this->primaryKey(),
            'domain_name' => $this->string(64)->notNull(),
            'phone' => $this->string(128)->notNull(),
            'address' => $this->string(512)->notNull(),
            'contact_text' => $this->text(),
            'cases_json' => $this->text(),
            'is_main' => $this->smallInteger(1)->defaultValue(0)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('subdomains');
    }
}
