<?php
/**
 * 欢迎交流php  array_map回调+闭包+use
 * @author  李文瑞 <164798922@qq.com>
 * @link    http://php.net/manual/zh/function.array-map.php
 */
$useA = 'A';
$useB = 'B';
$useC = 'C';
$array = array(1,2,3,4,5,6);
$func  = function($value) use ($useA,$useB,$useC){
    $useC = 'D';
    return $value . $useA . $useB;
};

$test = array_map($func,$array);

/**
 @debug 李文瑞
 */
echo "test:";
echo "<pre>";
    print_r($test);
echo "</pre>";
echo '<hr>';
/**
 @debug 李文瑞
 */
echo "useC:";
echo "<pre>";
    print_r($useC);
echo "</pre>";
echo '<hr>';


//use 引用
$func  = function($value) use ($useA,$useB,&$useC){
    $useC = 'D';
    return $value . $useA . $useB;
};

$test = array_map($func,$array);
var_dump($useC);