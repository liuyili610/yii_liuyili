<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m171226_032820_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull()->comment('左值'),
            'rgt' => $this->integer()->notNull()->comment('右值'),
            'depth' => $this->integer()->notNull()->comment('深度'),
            'name' => $this->string()->notNull()->comment('分类名字'),
            'parent_id'=>$this->integer()->notNull()->comment('父类编号'),
            'intro'=>$this->string()->comment('商品分类介绍')
        ]);
    }




    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
