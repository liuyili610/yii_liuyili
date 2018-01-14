<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property string $id 商品编号
 * @property string $name 商品名称
 * @property string $sn 货号
 * @property string $logo 商品图标
 * @property int $goods_category_id 商品分类
 * @property int $brand_id 品牌编号
 * @property string $market_price 市场价格
 * @property string $shop_price 本店价格
 * @property int $stock 库存
 * @property int $is_on_sale 是否上架 1是2否
 * @property int $status 状态1正常2回收站
 * @property int $sort 排序
 * @property int $inputtime 录入时间
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'inputtime'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品编号',
            'name' => '商品名称',
            'sn' => '货号',
            'logo' => '商品图标',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌编号',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架 1是2否',
            'status' => '状态1正常2回收站',
            'sort' => '排序',
            'inputtime' => '录入时间',
        ];
    }

    public function getImages()
    {
        return $this->hasMany(GoodsGallery::className(),['goods_id'=>'id']);
    }
}
