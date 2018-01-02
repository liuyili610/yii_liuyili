<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 21:02
 */

namespace backend\controllers;


use backend\models\Admin;
use common\models\LoginForm;
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
        if($request->isPost){
            $admin->load($request->post());
            //后台验证
            if ($admin->validate()) {
                $admin->password = \Yii::$app->security->generatePasswordHash($admin->password);
                //验证成功保存数据
                if ($admin->save()) {
                    return $this->redirect(['admin/index']);
                }
            }else{
                echo "验证失败";exit;
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
                echo "<pre>";
//                var_dump($admin);exit;
                $admin->password = \Yii::$app->security->generatePasswordHash($admin->password);
                $admin->add_time=date('Ymd H',time());
                //验证成功保存数据
                if ($admin->save()) {
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
        $model = new LoginForm();
        $request = new Request();
        if ($request->isPost) {
            $model->load($request->post());
            $result = Admin::find()->where(['name'=>$model->username])->one();
            if($result){
                //哈希转义
                $password = \Yii::$app->security->validatePassword($model->password,$result->password);
                if($password){
                    \Yii::$app->user->login($result,$model->rememberMe = 1?3600*24*7:0);
                    return $this->redirect(['admin/index']);
                }else{
                    $model->addError('password','密码错误');
                }
            }else{
                $model->addError('username','该用户不存在');
            }

        }
//            var_dump($model->getErrors());

        return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout(true);
        return $this->redirect(['admin/index']);
    }
}