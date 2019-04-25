<?php
session_start();

//error_reporting(E_ERROR);
include "includes/config.php";
include "includes/connect.php";
include "includes/common.php";
include "includes/filter.php";
include "lib/tmp.php";



//die($_SERVER['REQUEST_URI']); 

if(empty( $_REQUEST['m']))
{
	//header("Location: index.php?m=user&act=login");
	//exit();
	$model="user";
	$act="login";
}
else
 {
 	$model =  $_REQUEST['m'] ;
$act =  $_REQUEST['act'] ;
	# code...
}


include "xcontrol/".$model.".php";
$obj=new $model;
$dt=$obj->$act();
if(!is_array($dt))
	$dt=$obj->res;

$dt['act']=$act;
show($model."_".$act.".html",$dt);

