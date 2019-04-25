<?php
session_start();

include "../includes/config.php";
include "../includes/connect.php";
include "../includes/filter.php";
include "../includes/common.php";
include "../lib/smsnew.php";

if (strlen(trim($_POST['mobile']))<>11||substr($_POST['mobile'],0,1)<>1) 
			{
				echo "手机号码不正确";
			}
else
{
	$passkey=rand(100000,999999);
	$_SESSION["passkey"]=$passkey;
	$_SESSION['mobile']=trim($_POST['mobile']);
	send($_POST['mobile'],"您的验证码是：".$passkey);
	echo "OK";
}




