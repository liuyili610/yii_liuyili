<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/22
 * Time: 15:16
 */

namespace backend\controllers;


use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use flyok666\qiniu\Qiniu;

class BrandController extends Controller
{
    //列表显示
    public function actionIndex()
    {
//        echo "小刘博";
//        $brands = Brand::find()->where(['status'=>1])->all();
//        $brands = Brand::findAll(['status'=> 1]);
        //首先找到需要的以及满足条件的对象，但不执行
        $query = Brand::find()->where(['status'=>1])->orderBy('id');
//        找到总页数
        $count = $query->count();
//        new 一个组件
        $pagination = new Pagination([
           'totalCount' => $count,
           'pageSize' => 5
        ]);
        //设置偏移量和限制
        $brands = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index', ['brands' => $brands,'pagination'=>$pagination]);
    }


    //添加
//    public function actionAdd()
//    {
//        $imgPath = "";
////        echo "小刘博";exit;
//        $brands = new Brand();
//        $request = new Request();
//        if($request->isPost){
//            //提交过后，开始加载
//            $brands ->load($request->post()) ;
////            var_dump($brands);exit;
//            //接收文件
//            $brands->fileImg = UploadedFile::getInstance($brands,"fileImg");
//            //如果没有传文件，那么就跳过这一段
//            if($brands){
//                //配置文件保存路径
//                $imgPath = "images/".uniqid().".".$brands->fileImg->extension;
////                保存文件到相应目录   并且不删除临时文件
//                $doIt = $brands->fileImg->saveAs($imgPath,false);
////                var_dump($doIt);exit;
//                if($doIt === "false"){
//                    echo "文件上传失败";
//                    return false;
//                }
//            }
//
//            //再去后台验证是否正确
//            if ($brands->validate()) {
//                $brands->logo=$imgPath;
////                $brands->up_time = date('Ymd H');
//                if ($brands->save(false)) {
//                    echo 1111;
//                    return $this->redirect(['brand/index']);
//                }
//            } else {
//                //TODO
//                var_dump($brands->getErrors());
//                exit;
//            }
//
//        }
//        return $this->render('add',compact('brands'));
//    }


    //新的添加方法
    public function actionAdd()
    {
        $brands = new Brand();
        $request = new Request();
        if($request->isPost){
            $brands->load($request->post());
            if ($brands->validate()) {
                $brands->save();
                \Yii::$app->session->setFlash('info','添加成功');
                return $this->redirect(['index']);
            }else{
                //TODO
                var_dump($brands->getErrors());exit;
            }
        }

        return $this->render('add', ['brands' => $brands]);
    }

    //品牌编辑
    public function actionEdit($id)
    {
//        $brands = new Brand();
        $brands = Brand::findOne($id);
        $request = new Request();
        if($request->isPost){
            $brands->load($request->post());
            if ($brands->validate()) {
                $brands->save();
                \Yii::$app->session->setFlash('info','修改成功');
                return $this->redirect(['index']);
            }else{
                //TODO
                var_dump($brands->getErrors());exit;
            }
        }

        return $this->render('edit', ['brands' => $brands]);
    }

    //品牌删除（只删除状态，不是真正意义上的删除）
    public function actionDel($id)
    {
//        echo 1111;exit;
        $brands = Brand::findOne($id);
        $brands->status=2;
        $brands->save();
        return $this->redirect(['brand/index']);
    }

    //回收站
    public function actionBack()
    {
        //显示状态为2的数据
        $brands = Brand::find()->where(['status'=>2])->all();
        //去视图
        return $this->render('back',compact('brands'));
    }

    //品牌还原
    public function actionBack_re($id)
    {
//        echo 111;
        $brands = Brand::findOne($id);
        $brands->status=1;
        $brands->save();
        return $this->redirect(['brand/index']);
    }
    //永久删除
    public function actionBack_del($id)
    {
        $brands = Brand::findOne($id)->delete();
        return $this->redirect(['brand/back']);
    }

    public function actionUpload()
    {
        // 正确时， 其中 attachment 指的是保存在数据库中的路径，url 是该图片在web可访问的地址
//        {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}

        //得到上传对象
//        $upload = UploadedFile::getInstanceByName('file');
//        //拼接路径
//        if($upload){
//            $path = "images/brand/".uniqid().".".$upload->extension;
//            if ($upload->saveAs($path,false)) {
//                $result = ['code'=>0,'url'=>'/'.$path,'attachment'=>$path];
//
//            }
//            return json_encode($result);
//        }
        $config = [
            'accessKey' => 'EAd29Qrh05q78_cZhajAWcbB1wYCBLyHLqkanjOG',//AK
            'secretKey' => '_R5o3ZZpPJvz8bNGBWO9YWSaNbxIhpsedbiUtHjW',//SK
            'domain' => 'http://p1ht4b07w.bkt.clouddn.com',//临时域名
            'bucket' => 'php0830',//空间名称
            'area' => Qiniu::AREA_HUADONG//区域
        ];

        $qiniu = new Qiniu($config);
        $picname = uniqid();
        $qiniu->uploadFile($_FILES['file']['temp_name'],$picname);
        $url = $qiniu->getLink($picname);
        //返回的结果
        $result = [
            'code' => 0,
            'url' => $url,
            'attachment' => $url

        ];
        return json_encode($result);

    }

}