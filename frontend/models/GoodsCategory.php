<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "goods_category".
 *
 * @property int $id
 * @property int $tree
 * @property int $lft 左值
 * @property int $rgt 右值
 * @property int $depth 深度
 * @property string $name 分类名字
 * @property int $parent_id 父类编号
 * @property string $intro 商品分类介绍
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'lft', 'rgt', 'depth', 'name', 'parent_id'], 'required'],
            [['tree', 'lft', 'rgt', 'depth', 'parent_id'], 'integer'],
            [['name', 'intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => '左值',
            'rgt' => '右值',
            'depth' => '深度',
            'name' => '分类名字',
            'parent_id' => '父类编号',
            'intro' => '商品分类介绍',
        ];
    }



//    public function getContent()
//    {
//        return $this->hasOne(GoodsIntro::className(),['goods_id','id']);
//    }
}
