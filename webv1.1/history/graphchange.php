<?php
include_once ("connect.php");
$strSN = $_POST['SN'];
$opt=$_POST['opt'];

$sql_query;
$result_set;
if($opt=='0')
{	
	//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$strSN."' and Time>DATE_SUB(CURDATE(), INTERVAL 3 MONTH) order by Time desc";
$result_set=mysql_query($sql_query);
}
else if($opt=='1')
{	
	//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$strSN."' and Time>DATE_SUB(CURDATE(), INTERVAL 1 MONTH) order by Time desc";
$result_set=mysql_query($sql_query);
}
else if($opt=='2')
{	
//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$strSN."' and Time>DATE_SUB(CURDATE(), INTERVAL 7 DAY) order by Time desc";
$result_set=mysql_query($sql_query);	
}

$strArray=0;
$i;
$j;
$temp;
$Time;
$flag=1;
$sun;
	
while ($row = mysql_fetch_array($result_set, MYSQL_ASSOC))
{	$sun++;
	if($Time){
		$Time .="_";
		$Time .=$row['Time'];
	}
	else { 
		$Time = $row['Time'];
	} 
	if($strArray){
		$strArray .="_";
		$strArray .=$row['Data'];
	}
	else { 
		$strArray = $row['Data'];
	} 
	if($flag){
	$item;
	$temp=explode("_",$row['Data']);
	for($i=0;$i<(count($temp)-2)/2;$i++)
	{
		if($item){
		$item .="_";
		$item .=$temp[$i*2+2];
		}
		else { 
			$item = $temp[$i*2+2];
		} 
	}
	$flag=0;
	}
}
/////

$itemarray=explode("_",$item);
$dataarray=explode("_",$strArray);
$tempx=array();
$Itemstr=array();
$datastrtemp;

for($i=0;$i<count($itemarray);$i++)
{
	for($j=0;$j<$sun;$j++)
	{
		$tempx[$j]=(int)($dataarray[(count($itemarray)*2+2)*$j+3+$i*2]);
	}
	$Itemstr["name"]=$itemarray[$i];
	$Itemstr["data"]=$tempx;
    $datastrtemp[]=$Itemstr;
}
$timestr = json_encode(explode("_",$Time));
$datastr = json_encode($datastrtemp);
$resultJson = array("time"=>$timestr,"data"=>$datastr);//json格式的数组
  echo urldecode(json_encode($resultJson));//Json格式输出
?> 