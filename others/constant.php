<?php
/**
 * 欢迎交流php "动态"获取类常量
 * @author 李文瑞 <164798922@qq.com>
 */
$tag = 'NULL';
$a = constant("test::TEST_".strtoupper($tag));
var_dump($a);//NULL
echo '<hr>';

$tag = 'ZERO';
$b = constant("test::TEST_".strtoupper($tag));
var_dump($b);//0
echo '<hr>';

$tag = 'ONE';
$c = constant("test::TEST_".strtoupper($tag));
var_dump($c);//1
echo '<hr>';

$tag = 'ONE1';
// 判断类常量除了反射没有更好的其他办法判断类常量是否存在，defined()函数仅适用于常量，而不是适用类常量。一个略不优雅的方式：用constant()函数再@抑制错误，但没法判断定义的是否是null
// $d = constant("test::TEST_".strtoupper($tag));
$d = @constant("test::TEST_".strtoupper($tag));
var_dump($d);//Warning: constant(): Couldn't find constant test::TEST_ONE1 in
echo '<hr>';


//php 反射
$class = new ReflectionClass("test");
if($class->hasConstant("TEST_NULL")){//检查类中是否已经定义了指定的常量
    $value = test::getConst('null');
    var_dump($value);
    echo '<hr>';
}else{
    echo '没有定义类常量';
    echo '<hr>';
}



class test{
    const TEST_NULL = NULL;
    const TEST_ZERO = 0;
    const TEST_ONE  = 1;

    public static function getConst($str){
        // $value = self::{"TEST_".strtoupper($str)};//这样会报错
        // $str   = "TEST_".strtoupper($str);
        // $value = self::{$str};//这样会报错
        return constant(__CLASS__."::TEST_".strtoupper($str));//这样可以动态的获取类常量的值
    }
}