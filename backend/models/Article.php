<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25
 * Time: 14:36
 */

namespace backend\models;


use app\models\ArticleCate;
use app\models\ArticleDetail;
use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name','cate_id','intro','status','sort'],'required'],
            [['cate_id','status','sort'],'integer'],
            [['create_time'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'文章编号',
            'name'=>'文章标题',
            'intro'=>'文章描述',
            'cate_id'=>'分类编号',
            'status'=>'状态',
            'create_time'=>'创建时间',
            'sort'=>'排序',
        ];
    }

    //在本表中设置一对一关系的方法
//设置1对1  get后面的是随便写的方法名gettypes
    public function getContent()
    {
        //return $this->hasOne(需要关联的类的名称, ['关外类的中的字段' => '当前类的字段']);
//下面的Types必须是关联的模型的名字，然后后面的是关联的字段，注意第一个必须是连接的表的字段相当于是id属于Types表
        return $this->hasOne(ArticleDetail::className(),['article_id'=>'id']);
    }
    public function getCate()
    {
        return $this->hasOne(ArticleCate::className(),['id'=>'cate_id']);
    }
}