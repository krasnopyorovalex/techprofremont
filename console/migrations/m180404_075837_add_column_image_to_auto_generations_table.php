<?php

use yii\db\Migration;

/**
 * Class m180404_075837_add_column_image_to_auto_generations_table
 */
class m180404_075837_add_column_image_to_auto_generations_table extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('auto_generations', 'image', $this->string(36));
    }

    public function down()
    {
        $this->dropColumn('auto_generations', 'image');
    }
}
