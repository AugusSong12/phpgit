<?php

header("Content-type: text/html; charset=utf-8");

$dbhost = "127.0.0.1";

$dbuser = "root";
$dbpass = "augus";

$dbname = "SNIKGpLDiTxxINZtalbX";



$timezone = 'PRC';


date_default_timezone_set($timezone);

$pdoInfo = 'mysql:host=' . $dbhost . ';port=3306;dbname=' . $dbname;




//include "filter.php";//敏感词过滤