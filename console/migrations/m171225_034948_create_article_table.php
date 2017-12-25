<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171225_034948_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey()->comment("文章编号"),
            'name'=>$this->string()->notNull()->comment("文章名字"),
            'cate_id'=>$this->smallInteger()->notNull()->comment("分类编号"),
            'intro'=>$this->string()->comment("描述简介"),
            'status'=>$this->smallInteger()->notNull()->comment("状态：1-显示 2-隐藏"),
            'create_time'=>$this->smallInteger()->comment("创建时间"),
            'sort'=>$this->smallInteger()->notNull()->comment("排序")
        ]);

        //创建文章的垂直表的后边一部分
        $this->createTable('article_detail',[
            'id'=>$this->primaryKey(),
            'article_id'=>$this->smallInteger()->notNull()->comment("对应文章表的id"),
            'content'=>$this->text()->notNull()->comment("文章内容")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
