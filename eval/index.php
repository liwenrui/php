<?php
/**
 * 通过PHP自定义协议实现把字符串代码变为可以执行代码
 */

include __DIR__.'/stringToPHPStream.php';

$str_code = 'array("foo"=>"bar")';
$str_code = 'phpinfo()';
stream_register_wrapper("annotate", "stringToPHPStream");
$var = include ("annotate://{$str_code}");

$var;