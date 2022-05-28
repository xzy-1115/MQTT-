$(function(){
	//页面加载完成之后执行
	pageInit();
});
function pageInit(){
 $("#list2").jqGrid({  
                url: "grid_data.json",  
                datatype: "json",  
                mtype: "POST",  
                colNames: ["学号", "姓名", "性别", "年龄", "专业", "邮箱", "电话号码"],  
                colModel: [  
                    {name: 'sno', index: 'sno', align: 'center'},  
                    {name: 'sname', index: 'sname', align: 'center'},  
                    {name: 'ssex', index: 'ssex', align: 'center'},  
                    {name: 'age', index: 'age', align: 'center'},  
                    {name: 'profession', index: 'profession', align: 'center'},  
                    {name: 'mailbox', index: 'mailbox', align: 'center'},  
                    {name: 'phonenumber', index: 'phonenumber', align: 'center'}  
                ],  
                altRows: true,//单双行样式不同  
                altclass: 'differ',  
                viewrecords: true,//显示总记录数  
                rowNum: 5,//每页显示记录数  
                altRows: true,//分页选项，可以下拉选择每页显示记录数  
                rowList: [5, 10, 20],//用于改变显示行数的下拉列表框的元素数组  
                autowidth: true,//自动匹配宽度  
                loadonce: true,  
                gridview: true, //加速显示  
                rownumbers: true,//添加左侧行号  
                sortable: true,  //可以排序  
                sortname: 'sno',  //排序字段名  
                sortorder: "asc",//排序方式：正序，本例中设置默认按sno倒序排序  
                pagerpos: "center",  
                pager: '#pager2'//表格数据关联的分页条，html元素  
  
            });  
             jQuery("#list2").jqGrid('setLabel',0, '序号','labelstyle');  	
	
	
	
	
	//创建jqGrid组件
/*	jQuery("#list2").jqGrid(
			{
				url : 'data/JSONData.json',//组件创建完成之后请求数据的url
				datatype : "json",//请求数据返回的类型。可选json,xml,txt
				colNames : [ 'Inv No', 'Date', 'Client', 'Amount', 'Tax','Total', 'Notes' ],//jqGrid的列显示名字
				colModel : [ //jqGrid每一列的配置信息。包括名字，索引，宽度,对齐方式.....
				             {name : 'id',index : 'id',width : 55}, 
				             {name : 'invdate',index : 'invdate',width : 90}, 
				             {name : 'name',index : 'name asc, invdate',width : 100}, 
				             {name : 'amount',index : 'amount',width : 80,align : "right"}, 
				             {name : 'tax',index : 'tax',width : 80,align : "right"}, 
				             {name : 'total',index : 'total',width : 80,align : "right"}, 
				             {name : 'note',index : 'note',width : 150,sortable : false} 
				           ],
				rowNum : 10,//一页显示多少条
				rowList : [ 10, 20, 30 ],//可供用户选择一页显示多少条
				pager : '#pager2',//表格页脚的占位符(一般是div)的id
				sortname : 'id',//初始化的时候排序的字段
				sortorder : "desc",//排序方式,可选desc,asc
				mtype : "post",//向后台请求数据的ajax的类型。可选post,get
				viewrecords : true,
				caption : "JSON Example"//表格的标题名字
			});
	jQuery("#list2").jqGrid('navGrid', '#pager2', {edit : false,add : false,del : false});*/
}