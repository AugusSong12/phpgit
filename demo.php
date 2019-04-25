
<?php 
// $servername = "localhost";
// $username = "root";
// $password = "augus";
 
// // 创建连接
// $conn = new mysqli($servername, $username, $password);
 
// // 检测连接
// if ($conn->connect_error) {
//     die("连接失败: " . $conn->connect_error);
// } 
// echo "连接成功";


$servername = "localhost";
$username = "root";
$password = "augus";
$dbname = "message_sys";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    echo "连接成功dpo"; 

    $sql = "INSERT INTO usermanager (id, name, username,password)
	VALUES ('12', 'Doe', 'demo','123')";
 
	if ($conn->query($sql) === TRUE) {
   	 echo "新记录插入成功";
	}
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

 //    echo "This is a test</br>"; 
 //    echo "asdfasdfadsf";
 //    $mysql_server_name="localhost"; //数据库服务器名称
 //    $mysql_username="root"; // 连接数据库用户名
 //    $mysql_password="augus"; // 连接数据库密码
 //    $mysql_database="student_sys"; // 数据库的名字
    
 //    // 连接到数据库
 //    $conn=mysqli_connect($mysql_server_name, $mysql_username,
 //                        $mysql_password);

	// var_dump($conn) ;

// $pdo = new PDO('mysql:host=localhost;dbname=student_sys;port=3306','root','augus');
// $pdo->exec('set names utf8');

// $stmt = $pdo->prepare("select * from table where id =:id");
// $stmt->bindValue(':id',1,PDO::PARAM_INT);
// $stmt->execute();
// $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $rows = $pdo->query("select * from table where id = 1")->fetchAll(PDO::FETCH_ASSOC);

?>