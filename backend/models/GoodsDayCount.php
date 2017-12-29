<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 21:55
 */

namespace backend\models;


use yii\db\ActiveRecord;

class GoodsDayCount extends ActiveRecord
{
    public function rules()
    {
        return [
            [['day','count'], 'required'],
            [['count'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => '商品编号',
            'day' => '日期',
            'count' => '商品数',
        ];
    }
}