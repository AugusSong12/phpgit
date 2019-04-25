<?php
session_start();
error_reporting(E_ERROR);
define('Root_Path',dirname(__FILE__)."/../../includes");
include Root_Path."/config.php";
include Root_Path."/connect.php";
include Root_Path."/common.php";
include Root_Path."/filter.php";

include Root_Path."/../lib/tmp.php";

if(empty($_REQUEST['m']))
	$model =  "minitools";
else
	$model=$_REQUEST['m'];
	//$_REQUEST['m'] ;

$act="index";
if(isset( $_REQUEST['act']))
$act =  $_REQUEST['act'] ;
if(isset($_GET['pid'])&&$_GET['pid']>0)
	$_SESSION['pid']=$_GET['pid'];

//echo Root_Path;

include Root_Path."/../xcontrol/".$model.".php";

//ini_set('display_errors',1);            //错误信息
//error_reporting(-1);                    //打印出所有的 错误信息
$obj=new $model;
if(method_exists($obj,$act))
	$dt=$obj->$act();
else
	{
		echo "<h1>欢迎使用预约猫</h1><br><img src='/app/images/yym.jpg'>";
		die;
	}

if(!is_array($dt))
	$dt=$obj->res;

	$dt['act']=$act;

	
		show("jizan.html",$dt);
	

