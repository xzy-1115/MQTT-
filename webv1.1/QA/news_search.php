<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($_POST);
//print_r($_POST);
header('Content-type:text/html;charset=utf-8');
//接收数据并验证

$title = isset($_POST['title']) ? trim($_POST['title']) : '';//title是字符串 


//数据验证：标题和内容均不能为空
if(empty($title)){
    //提示同时回到提交页
    header('Refresh:1;url=news.php');//header前不能有输出，header:refresh不会阻止脚本执行
    //标题和内容至少有一个为空
    //阻止脚本继续执行
    exit('您检索的标题关键字为空，请在标题后面的文本框中输入要检索的标题！') ;
}
//组织sql更新到数据库
$sql = "select * from qa_list where title LIKE '%{$title}%'";
include_once ("connect.php");
$res = mysql_query($sql);//拿到结果集
//循环遍历所有结果
$news = array();//保存取出的一条记录（数组，每个元素是一个字段）
//方案1：获取结果集记录数，然后for循环
//$num = mysql_num_fields($res);//这块老师讲的有问题此函数返回列的个数，而不是返回行的个数,此处不应使用此函数
/*
$num = mysql_num_rows($res);//mysql_num_rows获取结果集记录数
for($i = 0;$i < $num;$i++){
    $news[] = mysql_fetch_assoc($res);  
}
print_r($news);
 */
//方案2，利用while循环，每次取得数据后判断保存数据结果，只要结果不为false,那么一直取
while($row = mysql_fetch_assoc($res) ){
    $news[] = $row;
}

//包含显示模版(HTML)
include_once 'news.html';
?>