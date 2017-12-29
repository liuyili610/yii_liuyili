<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods_category".
 *
 * @property int $id
 * @property int $lft 左值
 * @property int $rgt 右值
 * @property int $depth 深度
 * @property string $name 分类名字
 * @property int $parent_id 父类编号
 * @property string $intro 商品分类介绍
 */
class GoodsCategory extends ActiveRecord
{
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());

    }

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
            [['intro','name', 'parent_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品类型编号',
            'lft' => '左值',
            'rgt' => '右值',
            'depth' => '深度',
            'name' => '分类名字',
            'parent_id' => '父类编号',
            'intro' => '商品分类介绍',
        ];
    }

    //得到层级结构
    public function getNameText(){
        return str_repeat("&ensp;",$this->depth*4).$this->name;
    }
}
