<?php
	include_once("../connect.php");
$DATASTR = $_GET['DATASTR']; 
$strArray = explode('_',$DATASTR); //count($strArray)
$i;
$num=0;
for($i=2;$i<count($strArray);){
	$a=$strArray[$i++];
	$sql_query="SELECT * FROM alarm_code WHERE id = '".$strArray[$i++]."' ";
    $res = mysql_query($sql_query);
    $result=mysql_fetch_assoc($res);
    $b=$result[Code];
	$c=$strArray[$i++];
	$d=$strArray[$i++];
	$e=$strArray[$i++];
	
$responce->rows[$num]['cell']=array($num,$a,$c,$b,$d,$e);
$num++;
}
//$responce->rows[0]['cell']=array(0,1,1,1,1);
echo json_encode($responce); 
?>