<?php

echo 'outra coisa';


$str = "<if condition="peoplep">tes  te<if/>";
preg_match('(.+|)(?:<if.+condition=")(.+)(?:">)(.+)(?:<if\/>)(.+|)', $str, $re);
$strs = split(' - ', $re[1]);
print_r($str);






?>


