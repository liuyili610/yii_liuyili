<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\models\GoodsCategory;
use frontend\models\GoodsIntro;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }



    public function actionLists($id)
    {
        //1、首先找到这个对象
        $cateO = GoodsCategory::findOne($id);
        //2、在找到他下面的所有的商品
        $cateSons = GoodsCategory::find()->where(['tree'=>$cateO->tree])->andWhere("lft>={$cateO->lft}")->andWhere("rgt<={$cateO->rgt}")->asArray()->all();
        //找到该分类的所有子类型
        $cateIds = array_column($cateSons, 'id');
        //再通过分类找到所有商品
        $goods = Goods::find()->where(['in','goods_category_id',$cateIds])->andWhere(['status'=>1])->all();
        return $this->render('list.php',compact('goods'));
    }


}
