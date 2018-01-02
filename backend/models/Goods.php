<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 18:11
 */

namespace backend\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Goods extends ActiveRecord
{
    public $imgFile;
    public static function tableName()
    {
        return 'goods';
    }

    public function rules()
    {
        return [
            [['name','market_price','shop_price','stock','is_on_sale','sort'], 'required'],
            [['sort', 'goods_category_id','brand_id','is_on_sale'], 'integer'],
            [['logo','status','imgFile','sn','inputtime'],'safe']
//            [['fileImg'],'image','extensions' => 'gif,jpg,png','skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品编号',
            'name' => '商品名字',
            'sort' => '排序',
            'status' => '商品状态',
            'logo' => '商品图片',
            'sn' => '货号',
            'goods_category_id'=>'商品分类编号',
            'brand_id'=>'商品品牌编号',
            'market_price'=>'市场价格',
            'shop_price'=>'本店价格',
            'stock'=>'库存',
            'is_on_sale'=>'是否上架',
            'inputtime'=>'录入时间',
            'imgFile'=>'多图上传'
        ];
    }

    //一对一品牌
    public function getBrands()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }

    //一对一商品分类
    public function getCate()
    {
//        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT=>['inputtime']
                ]
            ]
        ];
    }

}