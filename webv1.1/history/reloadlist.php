<?php

include_once ("connect.php");
$SN=$_GET['SN'];
$indexnum=(int)$_GET['indexnum'];

//$SN="123";
$sql_query="SELECT * FROM device_data_save WHERE SN='".$SN."' order by Time desc";
$result_set=mysql_query($sql_query);

$i;
$temp;
$num=0;

$input = array();
$index=1;
while ($row = mysql_fetch_array($result_set, MYSQL_ASSOC))
{	
		if(($indexnum-1)*20<$index  &&  $index<=$indexnum*20){
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
		$index++;
}

	echo json_encode($responce); 



?>




