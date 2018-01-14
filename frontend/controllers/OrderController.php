<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 16:50
 */

namespace frontend\controllers;


use frontend\models\Address;
use yii\web\Controller;

class OrderController extends Controller
{
    public function actionIndex()
    {
        if(\Yii::$app->user->isGuest){
            return $this->redirect(['user-login/login','back'=>2]);
        }
        $address = Address::find()->all();
        return $this->render('orderlist',compact('address'));
    }


    public function actionAdd()
    {
        
    }


    public function actionEdit()
    {
        
    }

}