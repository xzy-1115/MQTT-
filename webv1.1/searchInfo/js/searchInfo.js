// // var arr_longitude = new Array();
// // var arr_latitude = new Array();
// // var arr_sn = new Array();
// // var arr_status = new Array();
// // var arr_point = new Array();
// // var mapSpots = new Array;
// // var url = "http://image.tupian114.com/20140419/09274112.png";
// // var content;
// // var myIcon = new BMap.Icon(url, new BMap.Size(40,30));
// // var opts = {
// // 				width : 180,     // 信息窗口宽度
// // 				height: 180,     // 信息窗口高度
// // 				title : "信息窗口" , // 信息窗口标题
// // 				enableMessage:true//设置允许信息窗发送短息
// // 			   };

// // $.ajax({
// // 			url:"searchInfo.php",
// // 			type:"POST",
// // 			dataType:"json",
// // 			async:false,
// // 			success:function(data){
// // 				alert(data.SNstr);
// // 			},
// // 			error: function(XMLHttpRequest, textStatus, errorThrown) {
// // //这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
// // 　　　　 		alert(XMLHttpRequest.responseText); 
// // 				alert(XMLHttpRequest.status);
// // 				alert(XMLHttpRequest.readyState);
// // 				alert(textStatus); // parser error;
// // 			}
// // 	});

// // function search(){
// // 	$.ajax({
// // 			url:"searchInfo.php",
// // 			type:"GET",
// // 			dataType:"json",
// // 			async:false,
// // 			success:function(data){
// // 				alert(data.SNstr);
// // 			},
// // 			error: function(XMLHttpRequest, textStatus, errorThrown) {
// // //这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
// // 　　　　 		alert(XMLHttpRequest.responseText); 
// // 				alert(XMLHttpRequest.status);
// // 				alert(XMLHttpRequest.readyState);
// // 				alert(textStatus); // parser error;
// // 			}
// // 	});
// // }










// function addSpots(arr_length){
//  alert("您有"+arr_length+"台设备!");
// 	 for(var i=0;i<arr_length;i++)
// 		 {
// 			content = "";
// 			content = "<div><span>SN码：" + arr_sn[i] + "</span></br>" +
// 							 "<span>设备状态：" + translateOnline(arr_status[i]) + "</span></br>" +
// 							 "<div class='btn'><a href='../DevAlarm/DevAla.html?SN=" + arr_sn[i] + "' target='fname'"
// 							 + "'>报警配置</a></div>" +"<div class='btn'><a href='../DevAlarmView/DevAlarmView.html?SN=" + arr_sn[i] + "' target='fname'"
// 							 + "'>报警信息</a></div>"+"<div class='btn'><a href='../DevRun/DevRun.html?SN=" + arr_sn[i] + "' target='fname'"
// 							 + "'>实时数据</a></div>"+"<div class='btn'><a href='../history/history.html?SN=" + arr_sn[i] + "' target='fname'"
// 							 + "'>历史数据</a></div>"+"<div class='btn'><a href='../DevCfg/DevCfg.html?SN=" + arr_sn[i] + "' target='fname'"
// 							 + "'>数据可视与报警开关配置</a></div>";
// 			marker = new BMap.Marker(arr_point[i]);
// 			map.addOverlay(marker);
// 			//var lable =  new BMap.Label(content,{offset:new BMap.Size(20,-10)});
// 			//marker.setLabel(lable);
// 			addClickHandler(content,marker); //添加点击处理程序（点击会出现sn码等信息）
// 		 }
	 
 
//  }

// function addClickHandler(content,marker){
// 	marker.addEventListener("click",function(e){
// 		openInfo(content,e)}
// 	);
// }
// function translateOnline(code){
// 	if (code == 0) {return "离线";}
// 	else if(code == 1) {return "在线";}
// 	else{return "error";}

// }

// function openInfo(content,e){
// 	var p = e.target;
// 	var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
// 	var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
// 	map.openInfoWindow(infoWindow,point); //开启信息窗口
// }