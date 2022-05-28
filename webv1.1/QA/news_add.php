<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
        //接收用户数据，实现新闻插入数据库功能
        header('Content-type:text/html;charset=utf-8');
        //接收用户数据
        //var_dump($_POST);
        $title = isset($_POST['title']) ? trim($_POST['title']):'';//title是字符串 
       // $isTop = isset($_POST['isTop']) ? (integer)$_POST['isTop']:2;//数字需求，不重要
        $content=isset($_POST['content']) ? trim($_POST['content']):'';//
      //  $publisher=isset($_POST['publisher']) ? trim($_POST['publisher']):'佚名';//trim通常针对字符串
        
        //数据验证：标题和内容均不能为空
        if(empty($title) || empty($content)){
            //提示同时回到提交页
            header('Refresh:3;url=news_add.html');//header前不能有输出，header:refresh不会阻止脚本执行
            //标题和内容至少有一个为空
            exit('标题和内容都不能为空') ;
            
        }
        //数据入库
        include_once ("connect.php");
        //SQL指令执行
       
        $sql = "insert into qa_list   values('".$title."','".$content."','".$_SESSION['UserName']."',now())";
        
        $insert_id = mysql_query($sql);
        
        //成功操作
        //提示同时跳转到列表页
        header('Refresh:1;url=news.html');//header前不能有输出，header:refresh不会阻止脚本执行
       
        echo $title . '增加成功！';
		
?>		