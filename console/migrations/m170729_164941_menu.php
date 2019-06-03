<?php

use yii\db\Migration;

class m170729_164941_menu extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'sys_name' => $this->string(128)->notNull()
        ],$tableOptions);

        $this->createTable('{{%menu_items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'link' => $this->string(512)->notNull(),
            'pos' => $this->integer()->notNull()->defaultValue(0),
            'parent_id' => $this->integer(),
            'menu_id' => $this->integer()
        ],$tableOptions);

        $this->createIndex('idx-menu-sys_name','{{%menu}}','sys_name');
        $this->createIndex('idx-menu-parent_id','{{%menu_items}}','parent_id');

        $this->addForeignKey('fk-menu-menu', '{{%menu_items}}','menu_id','{{%menu}}','id','CASCADE','CASCADE');
        $this->addForeignKey('fk-menu-parent', '{{%menu_items}}','parent_id','{{%menu_items}}','id','CASCADE','RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%menu_items}}');
        $this->dropTable('{{%menu}}');
    }
}
