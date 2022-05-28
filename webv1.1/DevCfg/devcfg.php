<?php
include_once ("../connect.php");
//$strSN = $_GET['SN'];
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction  
$SN = $_GET['SN'];
//$SN="123";
$strProtocolVer ;


$sql_query="SELECT * FROM device_protocol WHERE SN='".$SN."' and UseFlag = 1 ";
$result_setx=mysql_query($sql_query);
$result=mysql_fetch_assoc($result_setx);
$strProtocolVer= $result[Protocol];
$sql =  "SELECT COUNT(*) AS count FROM protocol_detail where  Protocol='".$strProtocolVer."'";
$result_set = mysql_query($sql);
$row = mysql_fetch_array($result_set,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit;
$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "");
$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
$VI;
$AL;

$sql="SELECT * FROM realtime_rules WHERE SN='".$SN."'  and Protocol = '".$strProtocolVer."'";
$result_set=mysql_query($sql);
//echo $sql;
$mask;
$alar;
$lengvis;
$num;
$sqln;
$result_setn ;
if(mysql_num_rows($result_set)>0){
	$resultx=mysql_fetch_assoc($result_set);
	$mask=$resultx[VMask];
	$alar=$resultx[AMask];
	$lengvis=strlen($mask);
	for($i=0;$i<$lengvis;$i++){
		$status1=substr($mask,$i,1);
		if($status1=='0'){$VI=1;}else $VI=0;
		$status2=substr( $alar,$i,1);
		if($status2=='0'){$AL=1;}else $AL=0;
		//echo $AL;echo $VI;
		$num=$i+1;
		$sqln="select * from  protocol_detail where Protocol='".$strProtocolVer."' and Offset=" .$num .";"; 
		$result_setn = mysql_query($sqln);
		$resultn=mysql_fetch_assoc($result_setn);
		//echo $num;echo  "'".$resultn[ItemName]."'";echo $VI;echo $AL;
		$responce->rows[$i]['cell']=array($num,$resultn[ItemName],$VI);
  
	}
}


echo json_encode($responce); 
?>