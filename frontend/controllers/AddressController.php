<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\helpers\Json;

class AddressController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    //地址列表展示
    public function actionIndex()
    {
        //首先保存新增的地址判断是不是已经登录
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(['user-login/login']);
        }
//        找到对应的登录用户的ID
        $user_id = \Yii::$app->user->id;
        $address = Address::find()->where(['user_id' => $user_id])->asArray()->all();
        return $this->render('index', compact('address'));
    }


    //地址修改
    public function actionEdit($id)
    {
        //找到对应的地址信息
        $addOne = Address::find()->where(['id' => $id])->one();
        return Json::encode($addOne);
    }

    //地址删除
    public function actionDel($id)
    {
        $address = Address::findOne($id);
        $address->delete();
        return $this->redirect(['address/index']);
    }


    public function actionAdd()
    {
        $request = \Yii::$app->request;
        //判定是否是post提交
        if ($request->isPost) {
            $data = $request->post();
//        var_dump($data['id']);
            if ($data['id']) {
                //id存在说明是修改

                $address = Address::findOne($data['id']);
//                var_dump($data);exit;
//                return $address;
                $address->name = $data['Address']['name'];
                $address->province = $data['Address']['province'];
                $address->city = $data['Address']['city'];
                $address->town = $data['Address']['town'];
                $address->address = $data['Address']['address'];
                $address->phone = $data['Address']['phone'];
                isset($data['Address']['status'])?$address->status=2:$address->status=1;
//                $address->status = $data['status'];
//                var_dump($address);exit;
                $address->save();
                return "修改成功";
//                var_dump($address->errors);
            } else {
                //说明是增加
                $address = new Address();

                //绑定数据
                $address->load($data);
                //后台验证数据
                if ($address->validate()) {
                    //现在是登陆状态，那么找出对应的用户的ID存入数据库
                    $user_id = \Yii::$app->user->id;
                    $address->user_id = $user_id;
                    //保存数据
                    $address->save();
                    var_dump($address);exit;
                    //保存成功，跳转
                    return  "添加成功";

                }
            }


        }
    }
}