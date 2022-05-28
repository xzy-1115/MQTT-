<?php


include_once ("connect.php");
$SN=$_GET['SN'];


$opt=$_GET['opt'];
$sql_query;
$result_set;
if($opt=='0')
{	
	//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$SN."' and Time>DATE_SUB(CURDATE(), INTERVAL 3 MONTH) order by Time desc";
$result_set=mysql_query($sql_query);
}
else if($opt=='1')
{	
	//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$SN."' and Time>DATE_SUB(CURDATE(), INTERVAL 1 MONTH) order by Time desc";
$result_set=mysql_query($sql_query);
}
else if($opt=='2')
{	
//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$SN."' and Time>DATE_SUB(CURDATE(), INTERVAL 7 DAY) order by Time desc";
$result_set=mysql_query($sql_query);	
}


$i;
$temp;
$num=0;

$input = array();

while ($row = mysql_fetch_array($result_set, MYSQL_ASSOC))
{	
		$temp=explode("_",$row['Data']);
		array_push($input,$row['Time']);
		for($i=0;$i<(count($temp)-2)/2;$i++)
	    {
			array_push($input,$temp[$i*2+3]);
		}

		$responce->rows[$num]['cell']=$input;
		$input = array();
		$num++;
}

	echo json_encode($responce); 

?>