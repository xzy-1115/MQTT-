<?php
include_once('../connect.php');
$strSN = $_POST['SN'];
$strProtocol;
$len;
$strPRO=$_POST['pro_name'];
	$sql="select * from  device_protocol where SN ='".$strSN."' and UseFlag= 1 "; 
    $res = mysql_query($sql);
    $result=mysql_fetch_assoc($res);
	if($result['Protocol']!=$strPRO){
		$resultJson = array("information"=>100);//json格式的数组
        echo urldecode(json_encode($resultJson));//Json格式输出
	}
	else {
	$strProtocol=$result['Protocol'];
    $sqlstr1 ="select * from realtime_rules where SN ='".$strSN."' and Protocol='".$strProtocol."' ";
    $ress1 = mysql_query($sqlstr1);
	$resss = mysql_fetch_assoc($ress1);
	$len=strlen($resss['VMask']);
	$item='';
	$unit='';
	$type='';
	$Readable='';
	$Writable='';
	$x;
			for($i=0;$i<$len;$i++){
				
				if(substr($resss['VMask'] , $i, 1)=='1')//假如此位为1，则xxx
				{   
					$sqlstr ="select *from  protocol_detail where Protocol= '".$strProtocol."' and Offset = ($i+1)  ";
					$ress = mysql_query($sqlstr);
					$result1=mysql_fetch_assoc($ress);
					if($item=='')
					{$item=$result1['ItemName'];}else{$item.="|";$item.=$result1['ItemName'];}
					if($unit=='')
					{$unit=$result1['Unit'];}else{$unit.="|";$unit.=$result1['Unit'];}
					if($type=='')
					{$type=(string)$result1['Type'];}else{$type.="|";$type.=(string)$result1['Type'];}
					if($Readable=='')
					{$Readable=(string)$result1['Readable'];}else{$Readable.="|";$Readable.=(string)$result1['Readable'];}
					if($Writable=='')
					{$Writable=(string)$result1['Writable'];}else{$Writable.="|";$Writable.=(string)$result1['Writable'];}
				}		
			}
		$resultJson = array("state"=>$item,"mask"=>$resss[VMask],"unit"=>$unit,"type"=>$type,"Readable"=>$Readable,"Writable"=>$Writable);//json格式的数组
        echo urldecode(json_encode($resultJson));//Json格式输出
	}
?>



			