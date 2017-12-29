<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 18:14
 */

namespace backend\controllers;


use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends Controller
{
    //主页面
    public function actionIndex()
    {
        $goods = Goods::find()->all();
        return $this->render('index',compact(['goods']));
    }

    //添加
    public function actionAdd()
    {
        $goods = new Goods();
        $daycount = GoodsDayCount::find()->count();

        $goodscate = GoodsCategory::find()->asArray()->all();
        $goodsbrand = Brand::find()->asArray()->all();
        $goodsArray1 = ArrayHelper::map($goodscate,'id','name');
        $goodsArray2 = ArrayHelper::map($goodsbrand,'id','name');


        $request = new Request();
        if($request->isPost){
            $goods->load($request->post());
            //验证货号是否为空，为空按自己的规则写
            if($goods->sn){
                //后台验证
                $goods->inputtime=date('Y-m-d',time());
                if ($goods->validate()) {
                    //验证成功,保存数据
                    $goods->save();
                    return $this->redirect(['goods/index']);
                }else{
                    \yii::$app->session->setFlash('danger','验证错误，请重新输入');
                }
            }else{
                $goods->sn = date('Ymd').$daycount;
                //后台验证
                $goods->inputtime=date('Y-m-d',time());
                if ($goods->validate()) {
                    //验证成功,保存数据
                    $goods->save();
                    return $this->redirect(['goods/index']);
                }else{
                    var_dump($goods->errors);exit;
                    \yii::$app->session->setFlash('danger','验证错误，请重新输入');
                }
            }


        }

        return $this->render('add',compact('goods','goodsArray1','goodsArray2'));
    }

    //修改
    public function actionEdit($id)
    {

    }

    //删除
    public function actionDel($id)
    {

    }
    
    //回收站
    public function actionBack()
    {
        
    }
    
    //文件上传的方法
    public function actionUpload()
    {
        //得到上传文件的实例对象
//        $file = UploadedFile::getInstanceByName("file");
        $file = UploadedFile::getInstanceByName("file");
        if ($file) {
            //路径
            $path = "images/goods/" . uniqid() . "." . $file->extension;
            //移动图片
            if ($file->saveAs($path, false)) {
                // {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
                //这个是webupload的配置
                $result = [
                    'code' => 0,
                    'url' => "/" . $path,
                    'attachment' => $path
                ];
                return json_encode($result);
            }
        }
    }
}