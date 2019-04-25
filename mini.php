<?php
session_start();

//error_reporting(E_ERROR);
include "includes/configmini.php";
include "includes/connect.php";
include "includes/common.php";
include "includes/filter.php";
include "lib/tmp.php";

const APPID1 = 'wx1e09736572c2d1de';
//const MCHID = '1494348812';
//const KEY = '5d7c5b96193de77f2413facb257895d6';
const APPSECRET1 = '0df199bb46aafed4f92dc03f66eac3d3';
const APPID = 'wx1e09736572c2d1de';
//const MCHID = '1494348812';
//const KEY = '5d7c5b96193de77f2413facb257895d6';
const APPSECRET = '0df199bb46aafed4f92dc03f66eac3d3';


//die($_SERVER['REQUEST_URI']); 

if(empty( $_REQUEST['m']))
{
	//header("Location: index.php?m=user&act=login");
	//exit();
	$model="minitools";
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

