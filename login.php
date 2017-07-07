<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录中</title>
</head>

<body>
<?php
// session_start();
$username=$_POST['Username'];//接收数据
$passwd=$_POST['Password'];
if((isset($username))&&(isset($passwd))){  //是否输入
   echo "<script language=\"JavaScript\">alert(\"hello\");</script>";  
   $con = mysql_connect("127.0.0.1:3306","root","0");
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
mysql_select_db("smart_home",$con);//smart_home
$dbusername=null;
$dbpassword=null;
$result=mysql_query("select * from users where uname='".$username."';");
$res = mysql_fetch_array($result);//查询结果
$dbusername=$res[1];
$dbpassword=$res[2];
if($dbusername==null){//如果为空 返回主页面
    echo "<script language=\"JavaScript\">alert(\"no user!\");</script>";
    header("Location:index.html");
 }
elseif($dbpassword!==$passwd){//如果密码错
    header("Location:index.html");
 }else{
    header("Location:menu.html"); //正确跳转
 }
 }
mysql_close($con);//关闭数据库
?>

</body>
</html>
