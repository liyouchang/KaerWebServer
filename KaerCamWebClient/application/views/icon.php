<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>

<?php 
function getAscill($str) {
	$arr = str_split ( $str );
	foreach ( $arr as $v ) {
		echo $v, "=", ord ( $v ), "\n";
	}
	echo "=============\r\n\r\n";
}
//A字符
$str = (pack ( "A*", "中国" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

//H字符
$str = (pack ( "H2", "ff" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

//C字符
$str = (pack ( "C*", "55", "56", "57" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

//i字符 短整形 32位 4个字节 64位8个字节
$str = (pack ( "i", "100" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

//s字符 短整形 2个字节
$str = (pack ( "s", "100" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

//l字符 长整形 4个字节
$str = (pack ( "l", "100" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

//f字符 单精度浮点 4个字节
$str = (pack ( "f", "100" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

//d字符 双精度浮点 8个字节
$str = (pack ( "d", "100" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';


$str = (pack ( "N", "10" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';

$str = (pack ( "a8", "1234567" ));
echo $str, "=", strlen ( $str ), "字节\n";
getAscill ( $str );
echo '<br/>';
?>
</body>
</html>
    
