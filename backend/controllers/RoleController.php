<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRoles();
        return $this->render('index',compact('roles'));
    }
    
    //添加角色
    public function actionAdd()
    {
        $auth = \Yii::$app->authManager;
        $model = new AuthItem();
        //为了添加分组的时候可以选择一些权限，需要获取全部权限
        $permission = $auth->getPermissions();
        //把所有权限转化成对应的键值对
        $perArr = ArrayHelper::map($permission,'name','description');
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $role = $auth->createRole($model->name);
            //设置分组的描述
            $role->description = $model->description;
            if ($auth->add($role)) {
                //如果权限有选择的话循环出来选择了的权限
                if($model->permissions){
                    foreach ($model->permissions as $permission){
                        //$permission是一个字符串，所以需要得到相应的对象
                        $permission = $auth->getPermission($permission);
                        //分组添加了那么在创建权限添加进分组里面去
                        $auth->addChild($role,$permission);
                    }
                }
            //添加成功，若没有选择权限的话那么直接跳转到这里
            \Yii::$app->session->setFlash('success','添加角色成功');
                return $this->refresh();
            }
        }
        return $this->render('add',compact('model','perArr'));
    }

    //分组修改
    public function actionEdit($name)
    {
        $auth = \Yii::$app->authManager;
        $model = AuthItem::findOne($name);

        //为了添加分组的时候可以选择一些权限，需要获取全部权限
        $permission = $auth->getPermissions();
        //把所有权限转化成对应的键值对
        $perArr = ArrayHelper::map($permission,'name','description');

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
//            echo 1111;exit;
            //得到角色
            $role = $auth->getRole($model->name);
//            var_dump($role);exit;
            //设置分组的描述
            $role->description = $model->description;
//            var_dump($role->description);exit;
                $auth->update($model->name,$role);
                //下面处理修改过程中权限的问题，与添加不同的是，修改需要把权限全部删除过后然后在添加，这个思路
                $auth->removeChildren($role);

                //如果权限有选择的话循环出来选择了的权限
                if($model->permissions){
                    foreach ($model->permissions as $permission){
                        //$permission是一个字符串，所以需要得到相应的对象
                        $permission = $auth->getPermission($permission);
                        //分组添加了那么在创建权限添加进分组里面去
                        $auth->addChild($role,$permission);
                    }
                }
                //添加成功，若没有选择权限的话那么直接跳转到这里
                \Yii::$app->session->setFlash('success','修改角色成功');
                return $this->refresh();
            }



        //当前角色所对应的权限 通过角色找权限
        $roles = $auth->getPermissionsByRole($name);
        //取出所有权限的key值
        $model->permissions = array_keys($roles);

        return $this->render('add',compact('model','perArr'));
    }


    //分组删除
    public function actionDel($name)
    {
        //实例化组件
        $auth = \Yii::$app->authManager;
        //找到角色
        $roles = $auth->getRole($name);
        //根据角色删除权限
        $auth->removeChildren($roles);
        //然后再删除角色，并判断
        if ($auth->remove($roles)) {
            return $this->redirect(['role/index']);
        }
    }


}
