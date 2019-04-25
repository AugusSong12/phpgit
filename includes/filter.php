<?php


if(isset($_REQUEST))
foreach($_REQUEST as $r)
{
	if( is_string($r)&&preg_match('/select|insert|update|delete|script|\\*|\*|union|into|load_file|outfile/i',$r))
	msgback("非法输入词，请检查");
}

// by gordon xi 过滤敏感词及非法注入
/*
function customError($error_level,$error_message,
$error_file,$error_line,$error_context)
 { 
 echo "<!--<b>Error:</b>[$error_level]: [$error_message] at [$error_file] line [$error_line]  $errstr";

 print_r($error_context);
 echo "-->";

 echo "<h1>欢迎使用预约猫</h1><br><img src='/app/images/yym.jpg'>";
 }
*/
//set error handler
//set_error_handler("customError");



$filterWords="刷单,操,艹,SB,sb,近平,泽民,克强";
$words=explode(",", $filterWords);


//$badword1 = array_combine($words,array_fill(0,count($badword),'*'));



$blacklist="/".implode("|",$words)."/i";

//echo $blacklist;


foreach ($_POST as $key => $value) {
	$str=$value;
//	echo $str;
//	$_POST[$key] = strtr($value, $badword1);
if(preg_match($blacklist, $str, $matches)){
	   // print "found:". $matches[0];
		msgback("有敏感词‘".$matches[0]."’,请编辑后重新提交");
	  } 

}