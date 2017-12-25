<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_cate".
 *
 * @property int $id 文章分类编号
 * @property string $intro 类型介绍
 * @property string $name 类型名字
 * @property int $status 类型状态
 * @property int $sort 类型排序
 * @property int $is_help 是否是帮助相关的分类
 */
class ArticleCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_cate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro', 'name', 'status', 'sort', 'is_help'], 'required'],
            [['status', 'sort', 'is_help'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类编号',
            'intro' => '分类介绍',
            'name' => '分类名称',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '是否是帮助相关的分类',
        ];
    }


}
