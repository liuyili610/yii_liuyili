<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property string $name 收货人
 * @property string $province 省份地址
 * @property string $city 城市地址
 * @property string $town 城镇地址
 * @property string $address 详细地址
 * @property int $user_id 购买者编号
 * @property string $phone 收货人手机
 * @property int $status 是否是默认地址 1为否2为是
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','province','city','town','address','phone'],'required'],
            [['status'],'safe'],
//            [['name', 'province', 'city', 'town', 'address', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收货人',
            'province' => '省份地址',
            'city' => '城市地址',
            'town' => '城镇地址',
            'address' => '详细地址',
            'user_id' => '购买者编号',
            'phone' => '收货人手机',
            'status' => '是否是默认地址 1为否2为是',
        ];
    }
}
