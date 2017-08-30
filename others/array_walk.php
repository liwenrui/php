<?php
/**
 * 欢迎交流php  array_walk
 * @author  李文瑞 <164798922@qq.com>
 * @link    http://php.net/manual/zh/function.array-walk.php
 */
class Cart{
    //在类里面定义常量用 const 关键字，而不是通常的 define() 函数。
    const PRICE_BUTTER = 1.00;
    const PRICE_MILK  = 3.00;
    const PRICE_EGGS  = 6.95;

    protected $products = [];
    public function add($product,$quantity){
        $this->products[$product] = $quantity;
    }

    public function getQuantity($product){
        //是否定义了
        return isset($this->products[$product])?$this->products[$product]:FALSE;
    }

    public function getTotal($tax){
        $total = 0.0;
        $callback = function($quantity,$product) use ($tax , &$total){
            //constant 返回常量的值
            //__class__返回类名
            $price = constant(__CLASS__."::PRICE_".strtoupper($product));//这样可以动态的获取类常量的值
            // $price = constant("Cart::PRICE_".strtoupper($product));//这样可以动态的获取类常量的值
            // $price = self::{"PRICE_".strtoupper($product)};//这样会报错
            // $str = "PRICE_".strtoupper($product);
            // $price = self::{$str};//这样会报错
            $total += ($price * $quantity)*($tax+1.0);
        };
        //array_walk() 函数对数组中的每个元素应用用户自定义函数。在函数中，数组的键名和键值是参数
        array_walk($this->products,$callback);
        //回调匿名函数
        return round($total,2);
    }
}

$my_cart = new Cart();
$my_cart->add('butter',1);
$my_cart->add('milk',3);
$my_cart->add('eggs',6);

print($my_cart->getTotal(0.05));