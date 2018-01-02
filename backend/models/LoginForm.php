<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 22:03
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $password;
    public $username;
    public $rememberMe;

    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['rememberMe'],'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '用户密码',
            'username' => '用户姓名',
        ];
    }
}