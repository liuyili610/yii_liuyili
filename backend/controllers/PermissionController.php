<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化auth组件
        $auth = \Yii::$app->authManager;
        $permissions = $auth->getPermissions();
        return $this->render('index',compact('permissions'));
    }

    //添加权限
    public function actionAdd()
    {
        $auth = \Yii::$app->authManager;
        $model = new AuthItem();
        //判断
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //首先创建权限 $permission就代表创建的这个权限的所有
            $permission = $auth->createPermission($model->name);
            //设置描述
            $permission->description = $model->description;
            //保存到数据库
            if ($auth->add($permission)) {
                //成功
                \Yii::$app->session->setFlash('success','添加权限'.$permission->description.'成功');
                return $this->refresh();
            }
        }
        //否则显示视图
        return $this->render('add',compact('model'));
    }

    //权限删除
    public function actionDel($name)
    {
        $auth = \Yii::$app->authManager;
        //找到权限
        $permission = $auth->getPermission($name);
        //删除  由auth组件来删
        if ($auth->remove($permission)) {
            return $this->redirect(['permission/index']);
        }
    }

    //权限修改
    public function actionEdit($name)
    {
        $auth = \Yii::$app->authManager;
        $model = AuthItem::findOne($name);
        //判断
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //首先获取对应的权限  必须是得到模型表单里面的额那个权限路径，因为要加以判断
            $permission = $auth->getPermission($model->name);
            //判断是否得到了对应权限的路径，返回的是布尔
            if($permission){
                //设置描述
                $permission->description = $model->description;
                //保存到数据库 需要知道对应的权限路径因为是主键相当于id
                if ($auth->update($name,$permission)) {
                    //成功
                    \Yii::$app->session->setFlash('success','修改权限'.$model->name.'成功');
                    return $this->redirect(['permission/index']);
                }
            }else{
                \Yii::$app->session->setFlash('danger','权限名字不能修改');
                //刷新
                return $this->refresh();
            }
            //设置描述
            $permission->description = $model->description;
            //保存到数据库
            if ($auth->add($permission)) {
                //成功
                \Yii::$app->session->setFlash('success','添加权限'.$permission->description.'成功');
                return $this->refresh();
            }
        }
        //否则显示视图
        return $this->render('add',compact('model'));
    }

}
