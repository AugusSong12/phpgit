<?php
session_start();

include "includes/config.php";
include "includes/connect.php";
include "includes/filter.php";
include "includes/common.php";
include "lib/tmp.php";

$model =  $_REQUEST['m'] ;
$act =  $_REQUEST['act'] ;

include "xcontrol/".$model.".php";
$obj=new $model;
$dt=$obj->$act();
show("app/".$model."_".$act.".html",$dt);

