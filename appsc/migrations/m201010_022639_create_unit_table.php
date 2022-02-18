<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%unit}}`.
 */
class m201010_022639_create_unit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit}}', [
            'id' => $this->primaryKey(),
            'race' => $this->string()->notNull()->comment('P T Z'),
            'name' => $this->string(32)->notNull(),
            'type' => $this->integer()->notNull()->comment('0Small 1Medium 2Large'),
            'force' => $this->integer()->notNull()->comment('0Ground 1Air'),

            'mineCost' => $this->integer(),
            'gasCost' => $this->integer(),
            'timeCost' => $this->integer(),
            'unitCost' => $this->float(), // zergling cost 0.5 unit

            'hp' => $this->integer()->comment('生命值'),
            'shield' => $this->integer()->comment('护盾值'),
            'armor' => $this->integer()->comment('初始防御值'), // 防御升级一次都是 1 点

            'energy' => $this->string(32)->comment('能量'),

            'sight' => $this->integer()->comment('视野值'),
            'sightBonus' => $this->integer(0)->comment('视野加强后值'),
            'speed' => $this->float()->comment('移动速度值'),
            'speedBonus' => $this->float()->comment('移动速度加强后值'),

            'createdAt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updatedAt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%unit}}');
    }
}
