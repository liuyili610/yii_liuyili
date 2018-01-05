<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 21:02
 */

namespace backend\controllers;


use backend\models\Admin;
use backend\models\LoginForm;
use yii\web\Controller;
use yii\web\Request;

class AdminController extends Controller
{
    public function actionIndex()
    {
        $admin = Admin::find()->all();
        return $this->render('index',compact('admin'));
    }
    public function actionDel($id)
    {
        $admin = Admin::findOne($id)->delete();
        return $this->redirect(['admin/index']);
    }
    public function actionEdit($id)
    {
        $admin = Admin::findOne($id);
        $request = new Request();
        $admin->scenario='update';
//        echo '<pre>';
        $password = $admin->password;
        $admin->password="";
//        var_dump($admin);exit;
         if($request->isPost){
            $admin->load($request->post());
            //后台验证
            if ($admin->validate()) {
                if(empty($request->post()['admin']['password'])){
                    $admin->password = $password;
                }else{
                    $admin->password = \Yii::$app->security->generatePasswordHash($request->post()["admin"]["password"]);
                }
                //验证成功保存数据
                if ($admin->save()) {
                    return $this->redirect(['admin/index']);
                }
            }else{
                echo "验证失败";
            }
        }
        return $this->render('add',compact('admin'));
    }
    public function actionAdd()
    {
        $admin = new Admin();
        $request = new Request();
        if($request->isPost){
            $admin->load($request->post());
            //后台验证
            if ($admin->validate()) {
                //密码哈希加密
                $admin->password = \Yii::$app->security->generatePasswordHash($admin->password);
                //创建时间
                $admin->add_time=date('Y-m-d H',time());
                //生成令牌  运用内置的函数生成随机字符串
                $admin->token = \Yii::$app->security->generateRandomString();
                //生成令牌创建时间
                $admin->token_create_time = time();
                //验证成功保存数据
                if ($admin->save()){
                    //保存数据之后添加分组  因为需要保存后才产生用户的id值
                    //1、首先实例化组件对象
                    $auth = \Yii::$app->authManager;
                    //2、找到那边填写的分组的信息
                    $grp = $auth->getRole($admin->group);
                    //3、分派用户到分组中去。然后他会自动保存数据，对应用户id和分组信息的数据表自动更新
                    $auth->assign($grp,$admin->id);
                    return $this->redirect(['admin/index']);
                }
            }else{
                echo "验证失败";exit;
            }
        }
        return $this->render('add',compact('admin'));
    }

    //登录方法
    public function actionLogin()
    {
        if(!\Yii::$app->user->isGuest){
            //如果不是游客表示登陆了的，就是记录密码时间还没过
            return $this->redirect(['goods/index']);
        }
        $model = new LoginForm();
        $request = \yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());

            if ($model->validate()) {
//                var_dump($model);exit;
//                echo 111;exit;
                $result = Admin::find()->where(['username' => $model->username])->one();
//                    var_dump($result);exit;
                if ($result) {
                    //哈希加密
                    $password = \Yii::$app->security->validatePassword($model->password, $result->password);
//                    var_dump($password);exit;
                    if ($password) {
                        \Yii::$app->user->login($result, $model->rememberMe = 1 ? 3600 * 24 * 7 : 0);
                        //组件登陆成功，设置登陆时间和登录ip
                        $result->last_login_time = time();
                        $result->last_login_ip = ip2long(\Yii::$app->request->userIP);
                        //更改完成，然后保存数据
                        $result->save();
                        return $this->redirect(['admin/index']);
                    } else {
                        $model->addError('password', '密码错误');
                    }
                } else {
                    $model->addError('username', '该用户不存在');
                }

            }else{
                var_dump($model->getErrors());
            }
        }


        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout(true);
        return $this->redirect(['admin/login']);
    }
}