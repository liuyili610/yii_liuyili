<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/11
 * Time: 14:26
 */

namespace frontend\controllers;



use frontend\components\ShopCart;
use frontend\models\Cart;
use frontend\models\Goods;
use frontend\models\GoodsGallery;
use frontend\models\GoodsIntro;
use function Sodium\add;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

class GoodsController extends \yii\web\Controller
{
    public function actionDetail($id)
    {
        $good = Goods::findOne($id);
        $goodContent = GoodsIntro::findOne($id);
//        var_dump($goodContent);exit;
        if($goodContent == null){
            $goodContent="";
        }
        return $this->render('detail',compact('good','goodContent'));
    }

    
    //添加购物车
    public function actionCart($id,$amount)
    {
        if(\Yii::$app->user->isGuest){
//-----------------------------------------------------------------------------------------封装之前的方法
//            //如果是游客
//            //2.1 取出Cookie中购物车数据  如果浏览器中的cookie值为空，那就赋值给他一个空数组$cartOld=$cartOld?$cartOld:[];
//            $cartOld = \Yii::$app->request->cookies->getValue('cart', []);
//            //2.2 判断$cartOld里有没有当前商品Id这个key值  如果所保存的cookie中有相同id即相同编号的商品，就是商品想通，那么数目相加
//            if (array_key_exists($id, $cartOld)) {
//                //已经存在商品 执行修改加操作  把商品的数目相加
//                $cartOld[$id] = $cartOld[$id] + $amount;
//            } else {
//                //这里说明添加的商品不存在，那么就是创建新的商品添加进去。
//                $cartOld[$id] = (int)$amount;
//            }
//            //1.1 得到设置COOKie的对象  作用就是用它来对cookie值进行操作
//            $setCookie = \Yii::$app->response->cookies;
//            //1.2 生成一个COOKie对象  相当于一个模型一个数组
//            $cookie = new Cookie([
//                'name' => 'cart',
//                'value' => $cartOld
//            ]);
//            //1.3 利用$setCookie添加一个Cookie对象
//            $setCookie->add($cookie);
//--------------------------------------------------------------------------------------以上是封装之前的方法
            //创建对象
            $shopCart = new ShopCart();
            //调用新建的组件类的方法
            $shopCart->add($id, $amount)->save();

        return $this->redirect(['goods/cart-lists']);
        }else{
            $request = \Yii::$app->request;
            //登录状态下，保存在数据库中
            $cart = new Cart();
            if($request->isGet){
//                echo 1111;exit;
                $user_id = \Yii::$app->user->identity->getId();
                $goodOne = Cart::find()->where(['goods_id'=>$id])->andWhere(['user_id'=>$user_id])->all();
                if($goodOne){
                    //如果商品编号在数据库存在,读取原始数据
                    //通过形参保存数据，
//                    var_dump($goodOne);exit;
                    $goodOne[0]->amount = $goodOne[0]->amount+$amount;
                    $goodOne[0]->save();
                        return $this->redirect(['goods/cart-lists']);
                }else{
                    //不存在
                    //通过形参保存数据，
                    $cart->goods_id = $id;
                    $cart->amount = $amount;
                    //读取的是user表里面的user是前端的   admin表是后台的
                    $user_id = \Yii::$app->user->identity->getId();
                    $cart->user_id = $user_id;
                    if ($cart->save()) {
                        //引入列表方法  直接跳转到列表
                        return $this->redirect(['goods/cart-lists']);
                    }
                }

            }

        }
    }

    //购物车清单
    public function actionCartLists()
    {
        //游客状态
        if (\Yii::$app->user->isGuest) {
            //获取cookie值
            $cart = \Yii::$app->request->cookies->getValue('cart', []);
            //得到购物车里面所有商品的编号   就是键名 -- id
            $goodIds = array_keys($cart);
            //通过查询把所有找到的商品编号对应的商品查询出来
            $goods = Goods::find()->where(['in', 'id', $goodIds])->asArray()->all();
            foreach ($goods as $k => $good) {
                //得到的goods是一个数组，下面在goods数组中追加一个键值，就是商品数量
                $goods[$k]['num'] = $cart[$good['id']];
                //在goods的基础上添加了一个键值对是id对应商品数量（要购买数量）
            }
        } else {
            //登录状态，数据库中处理。
            //1、读取查询数据登录的这个用户的信息
            $user_id = \Yii::$app->user->identity->getId();
            $cartM = Cart::find()->where(['user_id'=>$user_id])->asArray()->all();
            //找到商品编号和数量对应的数组
            $cartGoods = ArrayHelper::map($cartM,"goods_id","amount");
            //找到所有的商品编号
            $goodIds = array_column($cartM,"goods_id");
            //查询出商品编号对应的信息
            $goods = Goods::find()->where(['in','id',$goodIds])->asArray()->all();
            //遍历
            foreach ($goods as $k => $good) {
                //追加购物车每个商品数量
                $goods[$k]['num'] = $cartGoods[$good['id']];
                //  $goods[1]['num']=$cart[$good['id']];
            }
        }
        return $this->render('cartlist',compact('goods'));
    }



    public function actionDelCart($id)
    {
        if(\Yii::$app->user->isGuest){
//            $cart = \Yii::$app->request->cookies->getValue('cart',[]);
//
//            unset($cart[$id]);
//
//            //得到cookie设置对象
//            $setCookie = \Yii::$app->response->cookies;
//
//            //1.2 生成一个COOKie对象
//            $cookie = new Cookie([
//                'name' => 'cart',
//                'value' => $cart
//            ]);
//            //1.3 利用$setCookie添加一个Cookie对象
//            $setCookie->add($cookie);
            $shopcart = new ShopCart();
            $shopcart->del($id);
            $shopcart->save();
            return $this->redirect(['goods/cart-lists']);
        }else{
            //找到相应用户
            $user_id = \Yii::$app->user->getId();
            //找到对应商品编号
            $goods_id = $id;
            //删除
//            找对象
            $cartGoods = Cart::findOne(['user_id'=>$user_id,'goods_id'=>$goods_id])->delete();
            return $this->redirect(['user/index']);
        }

    }


    public function actionUpdateCart($id,$amount)
    {
        if(\Yii::$app->user->isGuest){
//            //如果是游客
//            //首先找到存了购物车数据的cookie
//            $cart = \Yii::$app->request->cookies->getValue('cart',[]);
//            $cart[$id] = $amount;
//
//            //得到cookie对象
//            $setCookie = \Yii::$app->response->cookies;
//            //生成一个对象
//            $cookie = new Cookie([
//                'name' => 'cart',
//                'value' => $cart,
//            ]);
//
//            $setCookie->add($cookie);
//-----------------------------------------------------------------------------------------------
            $shopcart = new ShopCart();
            $shopcart->update($id,$amount);
            $shopcart->save();
//-------------------------------------------------------------------------------------------------------
        }else{
            //如果是登录  利用数据库
            //首先找到对应的用户，
            $user_id = \Yii::$app->user->getId();
            //找到对应的商品编号
            $good_id = $id;
            //存入数据库中去
            $goodOne = Cart::find()->where(['goods_id'=>$good_id])->andWhere(['user_id'=>$user_id])->one();
            $goodOne->amount = $amount;
            $goodOne->save();
        }
    }

}