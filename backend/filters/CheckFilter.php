<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4
 * Time: 15:06
 */

namespace backend\filters;


use yii\base\ActionFilter;
use yii\web\HttpException;

class CheckFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        //$action->uniqueid代表的是当前的方法（函数）的路径
        if (!\Yii::$app->user->can($action->uniqueId)) {
            throw new HttpException(403,'您没有权限');
        }

        return parent::beforeAction($action);
//        return true;
    }
}