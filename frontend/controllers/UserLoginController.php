<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/10
 * Time: 18:21
 */

namespace frontend\controllers;


use frontend\components\ShopCart;
use frontend\models\User;
use frontend\models\UserLogin;
use yii\captcha\CaptchaAction;
use yii\web\Controller;

class UserLoginController extends Controller
{
    public $enableCsrfValidation = false;

    //验证码
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }
    //登录
    public function actionLogin($back=1)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['user/index']);
        }
        //创建实例

        if(\Yii::$app->request->isPost){
            $username = \Yii::$app->request->post('username');
            $password = \Yii::$app->request->post('password_hash');
            $userlogin= User::findOne(['username'=>$username]);

            if ($userlogin) {

//如果用户存在那么开始验证密码
                if (\Yii::$app->security->validatePassword($password,$userlogin->password_hash)) {
                    //验证密码也正确那么使用组件登录
                    \Yii::$app->user->login($userlogin, $userlogin->chb ? 3600 * 24 * 7 : 0);
                    //实例化对象
//                        ShopCart::
                    $shopCart = new ShopCart();
                    //未登录状态购物车数据更新到数据库
                    $shopCart->synDb();//同步到数据库
                    //清空本地购物车数据，

                    $shopCart->flush()->save();//清空本地购物车数据
//                        echo \yii::$app->user->identity->username;
                    //返回数据--登陆成功
//                        return "1";
                    return $back;
                }
            }
        }
//        var_dump($userlogin->getErrors());exit;
//        else{
//            var_dump($user->getErrors());
//        }
//        return $this->render('userlogin');
        return $this->render('userlogin');
    }
    
    //退出登录
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['user/index']);
    }
}