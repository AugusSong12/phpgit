<?php
session_start();

//error_reporting(E_ERROR);
include "includes/configmini.php";
include "includes/connect.php";
include "includes/common.php";
include "includes/filter.php";
include "lib/tmp.php";

const APPID = 'wx9eebd811f4014cd5';
//const MCHID = '1494348812';
//const KEY = '5d7c5b96193de77f2413facb257895d6';
const APPSECRET = '3a9fd081e4976bbea44804bc2ef1983a';
const APPID1 = 'wx9eebd811f4014cd5';
//const MCHID = '1494348812';
//const KEY = '5d7c5b96193de77f2413facb257895d6';
const APPSECRET1 = '3a9fd081e4976bbea44804bc2ef1983a';


//die($_SERVER['REQUEST_URI']); 

if(empty( $_REQUEST['m']))
{
	//header("Location: index.php?m=user&act=login");
	//exit();
	$model="minituan";
	//$act="login";
}

$act=$_REQUEST['act'];

include "xcontrol/".$model.".php";
$obj=new $model;
$dt=$obj->$act();
if(!is_array($dt))
	$dt=$obj->res;

$dt['act']=$act;
echo json_encode($dt);
//show($model."_".$act.".html",$dt);

