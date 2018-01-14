<?php

namespace frontend\controllers;

use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
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


    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegist()
    {
        $request = \Yii::$app->request;
        $user = new User();
        if ($request->post()) {
            //绑定数据
            $user->load($request->post());
            //后台验证
            if ($user->validate()) {
                $user->password_hash = \Yii::$app->security->generatePasswordHash($user->password_hash);
                $user->auth_key = \Yii::$app->security->generateRandomString();
                if ($user->save(false)) {
                    return Json::encode(
                        [
                            'status'=>'1',
                            'msg'=>'注册成功',
                            'data'=>null
                        ]
                    );
                }
            }
            return Json::encode(
                [
                    'status'=>'0',
                    'msg'=>'注册失败',
                    'data'=>$user->errors
                ]
            );

        }
        return $this->render('regist');
    }

    
    //登录
//    public function actionLogin()
//    {
//        if (!\Yii::$app->user->isGuest) {
//            return $this->redirect(['user/index']);
//        }
//        //创建实例
//        $user = new User();
//        $request = \Yii::$app->request;
//        if($request->isPost){
//            //绑定数据
//            $user->load($request->post());
//            var_dump($user);exit;
//            if ($user->validate()) {
//                //检验用户是否存在，
//                $checkNa = User::findOne(['username'=>$user->username]);
//                if ($checkNa) {
//                    //如果用户存在那么开始验证密码
//                    if (\Yii::$app->security->validatePassword($user->password_hash,$checkNa->password_hash)) {
//
//                        //验证密码也正确那么使用组件登录
//                        \Yii::$app->user->login($checkNa,3600*24*7);
//                        echo \yii::$app->user->identity->username;
//                        //返回数据--登陆成功
//                        return "1111";
//                    }else{
//                        $user->addError('password_hash','密码不正确');
//                    }
//                }else{
//                    $user->addError('username','用户名错误或者不存在');
//                }
//            }
//        }else{
//            var_dump($user->getErrors());
//        }
//        return $this->render('login');
//    }


    //创建随机验证码--手机
    public function actionSms($phone)
    {
        //生成随机验证码
        $code = rand(100000,999999);

        //配置文件---阿里云短信插件配置
        $config = [
            'access_key' => 'LTAIRLyiC9HoigTU',//应用ID
            'access_secret' => 'Ww7iZComeu0BYme2jO18Uo9gNu5KCA',//秘钥
            'sign_name' => '刘毅力',//签名
        ];

//        //3.创建短信发送对象（就是下载的那个插件的对象），内置对象
        $codeObj=new AliSms();
        //发送短信
        $response = $codeObj->sendSms($phone, 'SMS_121135607', ['code'=> $code], $config);

        //保存随机验证码存入session
        \Yii::$app->session->set($phone,$code);
        return $code;
    }

    //创建方法取出session中的验证码-shouji
    public function actionCheck($tel)
    {
        //取出session
        $getCode = \Yii::$app->session->get($tel);
        return $getCode;
    }

    public function actionTest()
    {
//        echo \yii::$app->user->identity->username;

        var_dump(\yii::$app->user->identity);
    }
}
