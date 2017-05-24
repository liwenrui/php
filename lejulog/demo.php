<?php

/**
 * 欢迎交流php  简单日志sdk的demo
 * @author 李文瑞 <164798922@qq.com>
 */

/**
   reids类型通过队列方式处理
   curl类型通过curl_multi_init并发请求和CURLOPT_TIMEOUT_MS毫秒级处理
 */

//引入sdk类文件
//其实是inclue lejulog.php文件
include('lejulog.php');

//日志类型
$type = 'access';

//日志数据
$data = array(1,2,3,4,5);

//添加日志
LeJuLog::add($type,$data);