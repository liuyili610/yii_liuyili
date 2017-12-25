<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $status
 * @property string $logo
 * @property string $intro
 */
class Brand extends \yii\db\ActiveRecord
{
    const STATU=[1=>'激活',2=>'隐藏'];
    //申明文件名这个属性
    public $fileImg;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','sort','status','intro'], 'required'],
            [['sort', 'status'], 'integer'],
            [['logo'],'safe']
//            [['fileImg'],'image','extensions' => 'gif,jpg,png','skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '品牌编号',
            'name' => '品牌名字',
            'sort' => '排序',
            'status' => '状态',
            'logo' => '品牌图片',
            'intro' => '简介',
        ];
    }
}
