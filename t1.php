<?php

echo md5("woshiyizhizhu");
//5d7c5b96193de77f2413facb257895d6
//echo phpinfo();
//定时提款
include "includes/config.php";
include "includes/connect.php";
include "xcontrol/user.php";

$dt=date("Y-m-d",strtotime("-7 days"));



$userinfo=getData("select u.openid,u.username,a.* from user as u,acount as a where u.id=a.userid and a.balance-a.locked>100 and tx.dt<'".$dt."' limit 0,2");
foreach ($userinfo as $key => $acount) 
{
	# code...
	user::tixian($acount);
}

?>