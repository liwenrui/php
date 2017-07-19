<?php
/**
 * 欢迎交流php   一致性hash
 * @author 李文瑞 <164798922@qq.com>
 */
include('hash.php');
$Flexihash = new Flexihash();
$Flexihash->addTarget('192.168.0.1');
$Flexihash->addTarget('192.168.0.2');
$Flexihash->addTarget('192.168.0.3');
$Flexihash->addTarget('192.168.0.4');
$Flexihash->addTarget('192.168.0.5');
$Flexihash->addTarget('192.168.0.6');
$Flexihash->addTarget('192.168.0.7');

var_dump($Flexihash->lookup('liwenrui'));
