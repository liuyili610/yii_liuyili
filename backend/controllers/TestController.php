<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 15:40
 */

namespace backend\controllers;


use app\models\Test;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class TestController extends Controller
{
    public function actionIndex()
    {
        $test = Test::find()->all();
        return $this->render('index', compact('test'));
    }

    public function actionAdd()
    {
        $test = new Test();
        $request = new Request();
        if ($request->isPost) {
            //绑定数据
            $test->load($request->post());

//            //接收文件
//            $test->files = UploadedFile::getInstance($test, 'files');
//            $path = "images/" . uniqid() . "." . $test->files->extension;
//            //上传文件的到本地文件夹下
//            $tusa = $test->files->saveAs($path, false);

            if ($test->validate()) {
//                $test->pic = $path;
                if ($test->save()) {
                    return $this->redirect(['test/index']);
                }
            }
        }
        return $this->render('add', compact('test'));
    }

    public function actionEdit()
    {

    }

    public function actionDel()
    {

    }

    public function actionUpload()
    {
//        //得到上传文件的实例对象
//        $file = UploadedFile::getInstanceByName("file");
//        if ($file) {
//            //路径
//            $path = "images/test/" . uniqid() . "." . $file->extension;
//            //移动图片
//            if ($file->saveAs($path, false)) {
//                // {"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
//                //这个是webupload的配置
//                $result = [
//                    'code' => 0,
//                    'url' => "/" . $path,
//                    'attachment' => $path
//                ];
//                return json_encode($result);
//            }
//        }


        //1、得到上传文件的实例对象
        $file = UploadedFile::getInstanceByName("file");
        if($file){
            //拼接图片的路径
            $path = "images/test/".uniqid().".".$file->extension;
            //保存路径
            if($file->saveAs($path,false)){
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