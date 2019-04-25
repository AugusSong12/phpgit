<?php

 require_once "wxsdk/jssdk.php";
 $jssdk = new JSSDK("wxcf13520e5d92f3f9", "8493b8261c66fb9ef6403b15586f6382");
//echo dirname(__FILE__)," ",$_SERVER['DOCUMENT_ROOT']," ";
  echo $jssdk->getJsApiTicket();
 //echo file_get_contents(dirname(__FILE__)."/user_login.html");


?>