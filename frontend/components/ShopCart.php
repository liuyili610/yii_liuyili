<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 14:51
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
    //私有化一个变量用来存储购物车里面的数据
    private $_cart;
    //构造函数
    public function __construct(array $config = [])
    {
        //一进入就开始获取cookie值。有值就获取，没有值就是空数组
        $this->_cart = \Yii::$app->request->cookies->getValue('cart', []);
        parent::__construct($config);
    }

    //购物车的添加
    public function add($id,$amount)
    {
        if(array_key_exists($id,$this->_cart)){
            //存在数据，形参和原来数据相加
            $this->_cart[$id] = $this->_cart[$id]+$amount;
        }else{
            //不存在原来数据，直接值就是形参
            $this->_cart[$id] = (int)$amount;
        }
        return $this;
    }

    //更新
    public function update($id,$amount)
    {
        if(isset($this->_cart[$id])){
            $this->_cart[$id] = $amount;
        }
        return $this;
    }

    //删除
    public function del($id)
    {
        unset($this->_cart[$id]);
        return $this;
    }

    //获取cookie值  查
    public function get()
    {
        return $this->_cart;
    }
    
    
    //清空，就是删除所有
    public function flush()
    {
        //给它赋一个空值
        $this->_cart = [];
        return $this;
    }

    //保存
    public function save()
    {
        //得到设置COOKie的对象  作用就是用它来对cookie值进行操作
        $setCookie = \Yii::$app->response->cookies;
        //1.2 生成一个COOKie对象  相当于一个模型一个数组
        $cookie = new Cookie([
            'name' => 'cart',
            'value' => $this->_cart,
            //设置cookie过期时间
            'expire'=>time()+3600*24*30*12
        ]);
        //利用创建的对象操作生成的cookie值
        $setCookie->add($cookie);
    }

    //当用户登陆时，在未登录状态下的购物车里面的数据需要保存到数据库
    public function synDb(){
        foreach ($this->_cart as $goodId=>$amount){
            //判断当前商品在数据库中是否存在
            $userId=\Yii::$app->user->getId();//用户Id
            //取出商品Id对应购物车数据

            $cart=Cart::findOne(['goods_id'=>$goodId,'user_id'=>$userId]);
            if ($cart) {
                //如果存在 修改+$amount
                $cart->amount+=$amount;
                $cart->save();
            }else{
                //新增
                $cart=new Cart();
                $cart->amount=$amount;
                $cart->goods_id=$goodId;
                $cart->user_id=$userId;
                $cart->save();
            }
    }
}
}