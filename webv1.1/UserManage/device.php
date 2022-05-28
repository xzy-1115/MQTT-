<?php
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction  
$user3namestr=$_GET['user3namestr'];
include_once ("connect.php");

$SQLSTRx =  "SELECT COUNT(*) AS count FROM device where  UserName = 'sunqi' and UseFlag =1 ";

$resultx = mysql_query($SQLSTRx);
$rowx = mysql_fetch_array($resultx,MYSQL_ASSOC);
$count = $rowx['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)

$responce = (object) array('page' => $page, 'total' => $total_pages, 'records' =>$count, 'rows' => "");

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

$i=0;
$num;
$sn;
$row;
$IndustryType;
$result = mysql_query("SELECT * FROM user_device  where UserName = '".$user3namestr."' and UseFlag =1 ");
while($row=mysql_fetch_array($result)){	
		$sn=$row['SN'];
		$sql_query1="select * from  device where SN ='".$sn."' "; 
		$res1 = mysql_query($sql_query1);
		$resulty1=mysql_fetch_assoc($res1);
		//echo $resulty1[SN],$resulty1[LocalName],$resulty1[IndustryType],$resulty1[Address];
		
		if($resulty1['IndustryType']=='0'){$IndustryType='智能车库';}
		if($resulty1['IndustryType']=='1'){$IndustryType='温控系统';}
		if($resulty1['IndustryType']=='2'){$IndustryType='农业大棚';}
		$responce->rows[$i]['cell']=array($resulty1['SN'],$resulty1['LocalName'],$IndustryType,$resulty1['Address']); 
		$i++;
}
echo json_encode($responce); 				
?>

