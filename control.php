<?php
function outlet01($i,$j){
  $con = mysql_connect("127.0.0.1:3306","root","
    ");
  if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
  mysql_select_db("smart_home",$con);//smart_home
  if ($j==1) {
    $querry = "select * from switch1 where id=(select max(id) from switch1)";
  }else{
    $querry = "select * from switch2 where id=(select max(id) from switch2)";
  }
  // $querry = "select * from switch1 where id=(select max(id) from switch1)";
  $sql = mysql_query($querry,$con);
  $result = mysql_fetch_array($sql);
  echo $result[$i];
  mysql_close($con);
}
function state($i){
  $con = mysql_connect("127.0.0.1:3306","root","");
  if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("smart_home",$con);//smart_home
    $querry = "select s,t from sta where SID=".$i;
    $sql = mysql_query($querry,$con);
    $result = mysql_fetch_array($sql);
    if($result[0]==1){
      if($result[1]>=1){
        echo "定时关";
      }else{
        echo "开";
      }
    }elseif($result[0]==0){
      if ($result[1]>=1) {
        echo "定时开";
      }else{
        echo "关";
      }
    }elseif ($result[0]==2) {
      echo "定时开";
    }else{
      echo "定时关";
    }
    // echo $result[0];
    mysql_close($con);
}
function timing($i){
  $con = mysql_connect("127.0.0.1:3306","root","");
  if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("smart_home",$con);//smart_home
    $querry = "select t from sta where SID=".$i;
    $sql = mysql_query($querry,$con);
    $result = mysql_fetch_array($sql);
    $hour = intval($result[0]/60);
    $minute =$result[0]%60;
    echo "时长：".$hour."H  ".$minute."M  ";
    mysql_close($con);
}
function getname($i){
  $con = mysql_connect("127.0.0.1:3306","root","");
  if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
  mysql_select_db("smart_home",$con);//smart_home
  $querry = "SELECT * FROM `name` WHERE id =".$i;
  // $querry = "select * from switch1 where id=(select max(id) from switch1)";
  $sql = mysql_query($querry,$con);
  $result = mysql_fetch_array($sql);
  echo base64_decode($result[1]);
  mysql_close($con);
}
?>
<!DOCTYPE html>
<html>

<head >
  <!-- <meta http-equiv="refresh" content="20"> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title>智能插座控制平台</title>

  <link rel="stylesheet" href="css/stylemenu.css" media="screen" type="text/css" />
  <script>
    function reloadPage(){
    location.reload()
  }
  </script>
  <script type="text/javascript">

    var xmlHttpRequest = null;
    
    function ajaxRequest(abc,cba)
    {
        if(window.ActiveXObject) // IE浏览器
        {
            xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        else if(window.XMLHttpRequest) // 除IE以外的其他浏览器
        {
            xmlHttpRequest = new XMLHttpRequest();
        }
        if(null != xmlHttpRequest)
        {
             // * GET方式向服务器发出一个请求
            xmlHttpRequest.open("GET", "on-off.php?switch="+abc[0]+"&name="+abc[1]+"&states="+abc[2]+"&time="+cba, true);
             /*
              * POST方式向服务器发出一个请求
              */
            // xmlHttpRequest.open("POST", "AjaxServlet", true);
            // 当发生状态变化时就调用这个回调函数
            xmlHttpRequest.onreadystatechange = ajaxCallBack;
            // 使用post提交时必须加上下面这行代码
            // xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
            // 向服务器发出一个请求
            xmlHttpRequest.send();    
        }
    }
    function ajaxRequest2(id,name)
    {
        if(window.ActiveXObject) // IE浏览器
        {
            xmlHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        else if(window.XMLHttpRequest) // 除IE以外的其他浏览器
        {
            xmlHttpRequest = new XMLHttpRequest();
        }
        if(null != xmlHttpRequest)
        {
             // * GET方式向服务器发出一个请求
            xmlHttpRequest.open("GET", "changename.php?id="+id+"&name="+name, true);
             /*
              * POST方式向服务器发出一个请求
              */
            // xmlHttpRequest.open("POST", "AjaxServlet", true);
            // 当发生状态变化时就调用这个回调函数
            xmlHttpRequest.onreadystatechange = ajaxCallBack;
            // 使用post提交时必须加上下面这行代码
            // xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
            // 向服务器发出一个请求
            xmlHttpRequest.send();    
        }
    }
    function ajaxCallBack()
    {
        var val = 3;
        if(xmlHttpRequest.readyState == 4)
        {
            if(xmlHttpRequest.status == 200)
            {
                var content = xmlHttpRequest.responseText;
                // alert(content);
                if(content.indexOf("send sucess")>= 0){
                  alert("sucess!\n3 s close");
                  window.opener.location.reload();
                  window.close();
                }else if(content.indexOf("cnnot send")>= 0){
                  alert("error!\n3 s close");
                  window.opener.location.reload(); //刷新父窗口中的网页
                  window.close();//关闭当前窗窗口
                }else if(content.indexOf("not link!")>= 0){
                  alert("not link!\n3 s close");
                  window.opener.location.reload();
                  window.close();
                }else if(content.indexOf("change name")>= 0){
                  alert("change name sucess");
                  window.opener.location.reload();
                  window.close();
                }
                // alert(content);
                // document.getElementById("div1").innerHTML = content;
            }
        }
    }
    function gettime(nmb)  
   {
    var hours = "hours"+nmb;
    var hoursa = document.getElementById(hours).value;
    hoursa = parseInt(hoursa*60);
    var min = "min"+nmb;
    var mina = document.getElementById(min).value;
    mina = parseInt(mina);
    var along = hoursa+mina;
    var ss = "00"+along;
    var sss = ss.substr(ss.length-3);
    var contorl = "contorl"+nmb;
    var controla = document.getElementById(contorl).value;
    // alert(sss+" "+control1);  
    ajaxRequest(controla,sss);
  }
  function changename(){
    var ids = "sid";
    var id = document.getElementById(ids).value;
    var sname = "sname";
    var name = document.getElementById(sname).value;
    // alert(id+name);
    ajaxRequest2(id,name);
  } 
  </script>
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
        <span class='card-content'>om-off</span>
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
<div class='char-long'>
  <div class='on-off'>
    <div class='on-top'>
    <span>插座一</span>
    <br>
    <input type="button" class="a_demo_one" value="重新加载页面" onclick="reloadPage()">
<!--           <a href="#" class="a_demo_one">
            Click me!
          </a> -->
    </div>
    <div class='on-top2'>
      <span >电压:</span>
      <span><?php outlet01(2,1);?></span>
      <br>
      <span>电流:</span>
      <span><?php outlet01(3,1);?></span>
    </div>
    <div class='bodyy'>
      <span ><?php getname(01)?></span>
      <br>
      <span class="boddy-center">状态：</span>
      <span><?php state(101);?></span>
      <br>
      <span class="bodd-center"><?php timing(101);?></span>
      <br>
      <br>
      <button onclick="ajaxRequest('111','000');">on</button>
      <button onclick="ajaxRequest('110','000');">off</button>
      <br>
      <!-- <form id="gettiming"> -->
      <select name="hours1" id="hours1">
      <option value="0">0h</option>
      <option value="1">1h</option>
      <option value="2">2h</option>
      <option value="3">3h</option>
      <option value="4">4h</option>
      <option value="5">5h</option>
      <option value="6">6h</option>
      <option value="7">7h</option>
      <option value="8">8h</option>
      <option value="9">9h</option>
      <option value="10">10h</option>
      <option value="11">11h</option>
      <option value="12">12h</option>
      </select>
      <select name="min1" id="min1">
      <option value="00">00</option>
      <option value="05">05</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
      <option value="30">30</option>
      <option value="35">35</option>
      <option value="40">40</option>
      <option value="45">45</option>
      <option value="50">50</option>
      <option value="55">55</option>
      </select>
      <br>
      <select name="contorl1" id="contorl1">
      <option value="112">定时开</option>
      <option value="113">定时关</option>
      </select>
      <br><!-- onclick="gettime();" -->
      <button onclick="gettime(1);">submit</button>  
      <!-- </form> -->
    </div>
    <div class='bodyy'>
      <span class='bodyy-center'><?php getname(02)?></span>
      <br>
      <span class="boddy-center">状态：</span>
      <span><?php state(104);?></span>
      <br>
      <span class="bodd-center"><?php timing(104);?></span>
      <br>
      <br>
      <button onclick="ajaxRequest('141','000');">on</button>
      <button onclick="ajaxRequest('140','000');">off</button>
      <br>
      <!-- <form id="gettiming"> -->
      <select name="hours4" id="hours4">
      <option value="0">0h</option>
      <option value="1">1h</option>
      <option value="2">2h</option>
      <option value="3">3h</option>
      <option value="4">4h</option>
      <option value="5">5h</option>
      <option value="6">6h</option>
      <option value="7">7h</option>
      <option value="8">8h</option>
      <option value="9">9h</option>
      <option value="10">10h</option>
      <option value="11">11h</option>
      <option value="12">12h</option>
      </select>
      <select name="min4" id="min4">
      <option value="00">00</option>
      <option value="05">05</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
      <option value="30">30</option>
      <option value="35">35</option>
      <option value="40">40</option>
      <option value="45">45</option>
      <option value="50">50</option>
      <option value="55">55</option>
      </select>
      <br>
      <select name="contorl4" id="contorl4">
      <option value="142">定时开</option>
      <option value="143">定时关</option>
      </select>
      <br><!-- onclick="gettime();" -->
      <button onclick="gettime(4);">submit</button> 
    </div>
    <div class='bodyy'>
      <span class='bodyy-center'><?php getname(03)?></span>
      <br>
      <span class="boddy-center">状态：</span>
      <span><?php state(103);?></span>
      <br>
      <span class="bodd-center"><?php timing(103);?></span>
      <br>
      <br>
      <button onclick="ajaxRequest('131','000');">on</button>
      <button onclick="ajaxRequest('130','000');">off</button>
      <br>
      <!-- <form id="gettiming"> -->
      <select name="hours3" id="hours3">
      <option value="0">0h</option>
      <option value="1">1h</option>
      <option value="2">2h</option>
      <option value="3">3h</option>
      <option value="4">4h</option>
      <option value="5">5h</option>
      <option value="6">6h</option>
      <option value="7">7h</option>
      <option value="8">8h</option>
      <option value="9">9h</option>
      <option value="10">10h</option>
      <option value="11">11h</option>
      <option value="12">12h</option>
      </select>
      <select name="min3" id="min3">
      <option value="00">00</option>
      <option value="05">05</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
      <option value="30">30</option>
      <option value="35">35</option>
      <option value="40">40</option>
      <option value="45">45</option>
      <option value="50">50</option>
      <option value="55">55</option>
      </select>
      <br>
      <select name="contorl3" id="contorl3">
      <option value="132">定时开</option>
      <option value="133">定时关</option>
      </select>
      <br><!-- onclick="gettime();" -->
      <button onclick="gettime(3);">submit</button> 
    </div>
    <div class='bodyy'>
      <span class='bodyy-center'><?php getname(04)?></span>
      <br>
      <span class="boddy-center">状态：</span>
      <span><?php state(102);?></span>
      <br>
      <span class="bodd-center"><?php timing(102);?></span>
      <br>
      <br>
      <button onclick="ajaxRequest('121','000');">on</button>
      <button onclick="ajaxRequest('120','000');">off</button>
      <br>
      <!-- <form id="gettiming"> -->
      <select name="hours2" id="hours2">
      <option value="0">0h</option>
      <option value="1">1h</option>
      <option value="2">2h</option>
      <option value="3">3h</option>
      <option value="4">4h</option>
      <option value="5">5h</option>
      <option value="6">6h</option>
      <option value="7">7h</option>
      <option value="8">8h</option>
      <option value="9">9h</option>
      <option value="10">10h</option>
      <option value="11">11h</option>
      <option value="12">12h</option>
      </select>
      <select name="min2" id="min2">
      <option value="00">00</option>
      <option value="05">05</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
      <option value="30">30</option>
      <option value="35">35</option>
      <option value="40">40</option>
      <option value="45">45</option>
      <option value="50">50</option>
      <option value="55">55</option>
      </select>
      <br>
      <select name="contorl2" id="contorl2">
      <option value="122">定时开</option>
      <option value="123">定时关</option>
      </select>
      <br><!-- onclick="gettime();" -->
      <button onclick="gettime(2);">submit</button> 
    </div>
  </div>
  <div class="on-off">
    <div class="bodyy">
    <span>将</span>
      <select name="sid" id="sid">
      <option value="01">插座一</option>
      <option value="02">插座二</option>
      <option value="03">插座三</option>
      <option value="04">插座四</option>
      </select>
    <span>的名字修改为</span> 
     <input type="text" name="sname" id="sname" /> 
CTYPE html>
<html>

<head >
  <!-- <meta http-equiv="refresh" content="20"> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <title></title>

  <link rel="stylesheet" href="css/stylemenu.css" media="screen" type="text/css" />
  <script>
    function reloadPage(){
    location.reload()
  }
  </script>
  <script type="text/javascript">
  var fso,f,r;
  var fso=new ActiveXObject(Scripting.FileSystemObject);
  // function changename(){
  //   var ids = "sid";
  //   var id = document.getElementById(ids).value;
  //   var sname = "sname";
  //   var name = document.getElementById(sname).value;
  //   // alert(id+name);
  //   ajaxRequest2(id,name);
  // }
  function readLine(){
    var line=document.all("line").value||0; //获取指定行号默认为从第一行 0 行开始
    var f = fso.opentextfile("data.txt", 1,true); 
    alert("ss");
    for(var i=0;i<line;i++){
        f.SkipLine(); //跳过指定行
    }
    r=f.ReadLine(); //读到目标行
    alert(r); 
    document.all("txtBox").innerText=r
    //输出结果
 }
  </script>
</head>

<body>
  <div>
    <h1 align="center" style="color:#2AC6BF;">智能插座控制平台</h1>
  </div>

  <div class="on-off">
    <div class="bodyy">
    <span>将</span>
      <select name="sid" id="sid">
      <option value="01">插座一</option>
      <option value="02">插座二</option>
      <option value="03">插座三</option>
      <option value="04">插座四</option>
      </select>
    <span>的名字修改为</span> 
     <input type="text" name="sname" id="sname" /> 
     <br><!-- onclick="gettime();" -->
      <button onclick="changename();">submit</button> 
    </div>
    <div class="bodyy">
    <input type="text" id="line">
    <button onclick="readLine();">submit</button> 
    <div id="txtBox">1</div>
    </div>
  </div>
</div>
<!--   <div class='on-off'>
    <div class='on-top'>
      插座二
    <br>
    <input type="button" class="a_demo_one" value="重新加载页面" onclick="reloadPage()">
    </div>
    <div class='on-top2'>
      <span >电压:</span>
      <span><?php outlet01(1,2);?></span>
      <br>
      <span>电流:</span>
      <span><?php outlet01(2,2);?></span>
    </div>
    <div class='bodyy'>
      <span >插座</span>
      <br>
      <span class="boddy-center">状态：</span>
      <span><?php state(200);?></span>
      <br>
      <span class="bodd-center"><?php timing(200);?></span>
      <br>
      <br>
      <button onclick="ajaxRequest('200','000');">on</button>
      <button onclick="ajaxRequest('201','000');">off</button>
      <br>
      <select name="hours5" id="hours5">
      <option value="0">0h</option>
      <option value="1">1h</option>
      <option value="2">2h</option>
      <option value="3">3h</option>
      <option value="4">4h</option>
      <option value="5">5h</option>
      <option value="6">6h</option>
      <option value="7">7h</option>
      <option value="8">8h</option>
      <option value="9">9h</option>
      <option value="10">10h</option>
      <option value="11">11h</option>
      <option value="12">12h</option>
      </select>
      <select name="min5" id="min5">
      <option value="00">00</option>
      <option value="05">05</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="25">25</option>
      <option value="30">30</option>
      <option value="35">35</option>
      <option value="40">40</option>
      <option value="45">45</option>
      <option value="50">50</option>
      <option value="55">55</option>
      </select>
      <br>
      <select name="contorl5" id="contorl5">
      <option value="202">定时开</option>
      <option value="203">定时关</option>
      </select>
      <br>
      <button onclick="gettime(5);">submit</button>  
    </div>
  </div> -->
</div>
<div style="text-align:center;clear:both;">
<script src="/gg_bd_ad_720x90.js" type="text/javascript"></script>
<script src="/follow.js" type="text/javascript"></script>
</div>

</body>

</html>
