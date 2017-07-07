4<?php
$myfile = fopen("initial1.txt", "r") or die("Unable to open file!");
$newfile = fopen("homechar.txt", "w") or die("Unable to open file!");
//只读打开格式文件，清空写打开最终表格文件
	$con = mysql_connect("127.0.0.1:3306","root","");
	if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    // $nowdata = date("Ymd");//当天的日期
	mysql_select_db("smart_home",$con);//smart_home
	$querry = "select * from W order by t DESC";//降序查询
    $sql = mysql_query($querry,$con);
    $i = 0;
    $finelec = "";//为避免报warning先生成空字符
    $findate = "";
    //select * from alle order by date DESC;降序
    while(($result = mysql_fetch_array($sql))&&($i<15)){//取最近15天的数据
        $res[$i]=$result;
        $data = $res[$i][0];//返回的日期
        $elec = $res[$i][1];//返回的电量
        if($i<14){
            //倒序的拼接字符串，所以最后一天前面不加逗号
            $finelec = ",".$elec.$finelec;
            $findate = ",\"".$data."\"".$findate;//分号前加转义字符
        }else{
            $finelec = $elec.$finelec;
            $findate = "\"".$data."\"".$findate;
        }
        $i++;
    }
    $line1 = 1;//行数计数
    while (!feof($myfile)) {//feof判断是否读完文件
        if ($line1 == 15) {
            fgets($myfile);//虽然源文件这一行不读但是指针向下走 
            fwrite($newfile,$finelec);//字符串读入特定行
        }elseif($line1 == 23){
            fgets($myfile);
            fwrite($newfile,$findate);
        }else{
            $newline = fgets($myfile);
            fwrite($newfile,$newline);//源文件拷贝进新文件
        }
        //15行和23行存放特定值
        $line1++;
    }
    mysql_close($con);
fclose($myfile);//关闭文件
fclose($newfile);
echo "hello";
?>
