<?php

use yii\db\Migration;

/**
 * Class m180330_085005_add_column_h1_to_auto_models_and_auto_generations_tables
 */
class m180330_085005_add_column_h1_to_auto_models_and_auto_generations_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('auto_models', 'h1', $this->string(512)->after('name'));
        $this->addColumn('auto_generations', 'h1', $this->string(512)->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('auto_models', 'h1');
        $this->dropColumn('auto_generations', 'h1');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180330_085005_add_column_h1_to_auto_models_and_auto_generations_tables cannot be reverted.\n";

        return false;
    }
    */
}
