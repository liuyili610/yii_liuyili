<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_cate`.
 */
class m171225_061720_create_article_cate_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_cate', [
            'id' => $this->primaryKey()->comment("文章分类编号"),
            'intro'=>$this->string()->notNull()->comment("类型介绍"),
            'name'=>$this->string()->notNull()->comment("类型名字"),
            'status'=>$this->smallInteger()->notNull()->comment("类型状态"),
            'sort'=>$this->smallInteger()->notNull()->comment("类型排序"),
            'is_help'=>$this->smallInteger()->notNull()->comment("是否是帮助相关的分类")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_cate');
    }
}
