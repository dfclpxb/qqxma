<?php
header("Content-Type: text/html;charset=utf-8");   
//设置数据的字符集utf-8 
//定义连接字符串
$servername = "localhost";
$username = "root";
$password = "whzyy456";
$dbname = "gh";

if (isset($_GET['s'])) {$m = strtolower(trim($_GET['s']));} else {	exit;  }
$error = 0;
$name='';
$description='';
$time = '';
if(!empty($_POST['title'])) {
	$title = trim($_POST['title']);
	if (function_exists('htmlspecialchars')) $title = htmlspecialchars($title, ENT_QUOTES);} else {$error = 1;}
	
	if(!empty($_POST['deadline'])) {
		 $date = trim(strtotime($_POST['deadline']));
			if (function_exists('htmlspecialchars')) $date = htmlspecialchars($date, ENT_QUOTES);
		} else {
			$date = date('Y-m-d H:i:s', time());
		    $date = strtotime($date); 
		}
		
if(!empty($_POST['name'])) {
	 $name = trim($_POST['name']);
	if (function_exists('htmlspecialchars')) $name = htmlspecialchars($name, ENT_QUOTES);}else {$error = 1;}
	
if(!empty($_POST['type'])) {
	 $type = trim($_POST['type']);
	 if (function_exists('htmlspecialchars')) $type = htmlspecialchars($type, ENT_QUOTES);
	 } else {$type = 1;
		}

if(!empty($_POST['description'])) {
	$description = trim($_POST['description']);
	if (function_exists('htmlspecialchars')) $description = htmlspecialchars($description, ENT_QUOTES);} else {$error = 1;}
	
$time = date('Y-m-d H:i:s', time());
$time = strtotime($time);
if ($error == 1) {echo '<script type="text/javascript ">alert("预约失败，请填写完整信息");history.go(-2);</script>'; exit;} 
		
else { 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {	die("连接失败: " . $conn->connect_error);}
mysqli_query($conn,'set names utf8'); 
$sql = "INSERT INTO  yygh_document (id,uid,name,title, category_id,group_id,description,root,pid,model_id,type,position,link_id,cover_id,display,deadline,attach,view,comment,extend,level,create_time,update_time,status)
VALUES (NULL ,  '1',  '$name',  '$title',  '2',  '0',  '',  '0',  '0',  '2',  '$type',  '0',  '0',  '0',  '1',  '$date',  '0',  '',  '23',  '0',  '1',  '$time',  '$time',  '1')";

if (mysqli_query($conn, $sql)) {
            $fid =  "SELECT id FROM yygh_document where name = '$name'";
            $result = $conn->query($fid);
			if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            $rid = $row["id"];
    }
}
		    $sql2 = "INSERT INTO  yygh_document_article (id,parse,content,template,bookmark) VALUES ('$rid' ,'0','$description','','')";
			if(mysqli_query($conn,$sql2)){
            echo '<script charset="utf8" type="text/javascript">alert("预约成功");history.go(-1);</script>';}
            $conn->close(); 
} 
else {echo '<script charset="utf8" type="text/javascript">alert("预约失败");history.go(-1);</script>' ;
$conn->close();
}
exit;
   }
?>
?>