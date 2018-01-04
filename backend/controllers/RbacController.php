<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 22:41
 */

namespace backend\controllers;


use yii\web\Controller;

class RbacController extends Controller
{
    //添加角色（相当于是创建分组）
    public function actionRole($name)
    {
        //已经在公共配置文件的主键目录中创建了一个叫authmanager的主键。直接用它来添加
        //实例化，创建对象
        $auth = \Yii::$app->authManager;
        //利用对象去创建角色
        $role = $auth->createRole($name);
        $role->description="角色姓名".$name;
        //保存创建的角色组
        $auth->add($role);
    }

    //添加权限
    public function actionPer($name)
    {
        //已经在公共配置文件的主键目录中创建了一个叫authmanager的主键。直接用它来添加
        //实例化，创建对象
        $auth = \Yii::$app->authManager;
        //添加权限
        $per = $auth->createPermission($name);
        $per->description="权限名称".$name;
        //添加
        $auth->add($per);
    }

    //把权限添加到组上面去
    public function actionRolePer($roleName,$perName)
    {
        //已经在公共配置文件的主键目录中创建了一个叫authmanager的主键。直接用它来添加
        //实例化，创建对象
        $auth = \Yii::$app->authManager;
//        找到角色
        $role = $auth->getRole($roleName);
//        找到权限
        $per = $auth->getPermission($perName);
        //添加权限给角色组
        $auth->addChild($role,$per);
    }

    //把用户分配到角色组中去
    public function actionAdminRole($id,$roleName)
    {
        //已经在公共配置文件的主键目录中创建了一个叫authmanager的主键。直接用它来添加
        //实例化，创建对象
        $auth = \Yii::$app->authManager;
        //找到用户id

        //找到角色组
        $role = $auth->getRole($roleName);
        $auth->assign($role,$id);
    }

    //判断用户有没有权限
    public function actionHasPer($name)
    {
        //已经在公共配置文件的主键目录中创建了一个叫authmanager的主键。直接用它来添加
        //实例化，创建对象
        $auth = \Yii::$app->authManager;
        \Yii::$app->user->can($name);
    }
}