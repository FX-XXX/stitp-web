<?php
function forecast(){
  $con = mysql_connect("127.0.0.1:3306","root","0");
  if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
  mysql_select_db("smart_home",$con);//smart_home
  $dataa = date("Y-m-d");
  $querry = "SELECT * FROM `forecast` WHERE t='".$dataa."'";
  $sql = mysql_query($querry,$con);
  $result = mysql_fetch_array($sql);
  echo $result[2]." W";
  mysql_close($con);
}
function data(){
  $dataa = date("Y-m-d");
  echo $dataa;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>智能插座控制平台</title>

  <link rel="stylesheet" href="css/stylemenu.css" media="screen" type="text/css" />
</head>

<body>
  <div>
    <h1 align="center" style="color:#2AC6BF;">智能插座控制平台</h1>
  </div>
  <div class='card-holder'>
  <div class='card-wrapper'>
    <a href='menu.html'>
      <div class='card bg-01'>
        <span class='card-content'>HOME</span>
      </div>
    </a> 
  </div>
  <div class='card-wrapper'>
    <a href='control.php'>
      <div class='card bg-02'>
        <span class='card-content'>on-off</span>
      </div>
    </a>
  </div>
  <div class='card-wrapper'>
    <a href='show1.php'>
      <div class='card bg-03'>
        <span class='card-content'>流程图</span>
      </div>
    </a>
  </div>
  <div class='card-wrapper'>
    <a href='show2.html'>
      <div class='card bg-04'>
        <span class='card-content'>结构图</span>
      </div>
    </a>
  </div>
  <div class='card-wrapper'>
    <a href='show3.html'>
      <div class='card bg-05'>
        <span class='card-content'>框架图</span>
      </div>
    </a>
  </div>
</div>
<div class='char'>
  <div class="imgg">
  <img src="01.png">
  </div>
  <span>深度学习模型预测耗电量的流程图</span>
  <div class="data">
  <span>日期：</span>
  <span><?php data();?></span>
  </br>
  <span>当日电量预测：</span>
  <span><?php forecast(); ?></span>
  </div>
</div>
</body>

</html>
