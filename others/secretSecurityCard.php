<?php
/**
 * 密保卡生成
 */
function getvcode(){
    $s = array();
    $str = '3456789abcdefghjkmnpqrstuvwxy';
 
    for($k = 65; $k<74; $k++){
        for($i = 1; $i<=9; $i++){
            $_x=substr(str_shuffle($str), $i, $i+2);
            $s[chr($k)][$i] = $_x[0].$_x[1];
        }
    }
    return $s;
}

var_dump(getvcode());
