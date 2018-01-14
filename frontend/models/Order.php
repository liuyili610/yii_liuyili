<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id 用户编号
 * @property string $name 收货人姓名
 * @property string $province 省份地址
 * @property string $city 城市地址
 * @property string $town 城镇地址
 * @property string $address 详细地址
 * @property string $phone 手机号码
 * @property int $delivery_id 配送方式ID
 * @property string $delivery_name 配送方式名字
 * @property string $delivery_price 运费
 * @property int $pay_type_id 支付方式
 * @property string $pay_type_name 支付方式名字
 * @property string $price 商品金额
 * @property int $status 订单状态 0已取消1待付款2待发货3待收货4完成
 * @property string $trade_no 第三方支付的交易号
 * @property string $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'price'], 'number'],
            [['name', 'province', 'city', 'town', 'address', 'phone'], 'string', 'max' => 255],
            [['delivery_name', 'pay_type_name', 'trade_no'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户编号',
            'name' => '收货人姓名',
            'province' => '省份地址',
            'city' => '城市地址',
            'town' => '城镇地址',
            'address' => '详细地址',
            'phone' => '手机号码',
            'delivery_id' => '配送方式ID',
            'delivery_name' => '配送方式名字',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式',
            'pay_type_name' => '支付方式名字',
            'price' => '商品金额',
            'status' => '订单状态 0已取消1待付款2待发货3待收货4完成',
            'trade_no' => '第三方支付的交易号',
            'create_time' => 'Create Time',
        ];
    }
}
