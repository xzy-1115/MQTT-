<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//更新数据到数据库
  session_start();
header('Content-type:text/html;charset=utf-8');

//接收数据并验证
$id = $_POST['id'];
$title = isset($_POST['title']) ? trim($_POST['title']) : '';//title是字符串 
$content=isset($_POST['content']) ? trim($_POST['content']) : '';//

//数据验证：标题和内容均不能为空
if(empty($title) || empty($content)){
    //提示同时回到提交页
    header('Refresh:3;url=news.html');//header前不能有输出，header:refresh不会阻止脚本执行
    //标题和内容至少有一个为空
    //阻止脚本继续执行
    exit('问题和答案都不能为空') ;
}
//组织sql更新到数据库
$sql = "update qa_list set Q = '".$title."', A ='".$content."' where Time = '".$id."' and UserName = '".$_SESSION['UserName']."' ";
include_once ("connect.php");
mysql_query($sql);
//提示成功
header('Refresh:1;url=news.html');
echo '更新成功！';

?>