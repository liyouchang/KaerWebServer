<?php include('header.php'); ?>


<div class="zTreeBackground " style="display:none">
			<ul id="treeDemo" class="ztree"></ul>
		</div>
			<div class="row ">
			<div class="box span5">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-calendar"></i>查询条件</h2>
					  	<div class="box-icon">
						  <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
				  	</div>
					<div class="box-content" >
						<form id="form_recordQuery" class="form-horizontal">
				      		<fieldset>
				      			<div class="control-group">
						  			<label class="control-label" for="recordType">录像类型</label>
						  				<div class="controls">
										  <select name="recordType" id="recordType">
										 	 <option value=2>前端录像</option>
										  <?php if($centerSvrType == 2):?>
										  	<option value=3>中心录像</option>
										  <?php endif;?>
											
										  </select>
										</div>
						 		</div>
				      			<div class="control-group">
						  			<label class="control-label" for="mydevice">查询设备</label>
						  				<div class="controls">
										  <select name="mydevice" id="mydevice">
										  </select>
										</div>
						 		</div>
								<div class="control-group ">
							 		<label class="control-label" for="startTime">开始时间</label>
							  		<div class="controls">
							    		<input type="text" class=" datetimepicker" name="startTime" id="startTime">
							  		</div>
								</div>
								<div class="control-group">
						  			<label class="control-label" for="endTime">结束时间</label>
						  			<div class="controls">
						    			<input type="text" class=" datetimepicker" name="endTime" id="endTime">
						  			</div>
								</div>
							 	<div class="form-actions">
						  			<button  type="submit" class="btn btn-primary">查询录像</button>
								</div>
					      	</fieldset>
					   	</form>	
					</div>
				</div><!-- span -->
				
				<div class="box span7" style="margin-left: 1.07%" >
					<div class="box-header well" data-original-title >
						<h2><i class="icon-globe"></i> 录像播放</h2>
						<div class="box-icon">
						<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content" >
	      				<div id="movie1" style="width:520px;height:400px;">
	      				</div>
					</div>
				</div><!--/span-->
			</div><!--/row-->
		
			<div class="row">	
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2>查询结果</h2>
						<div class="box-icon">	
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div id="recordFileList" class="box-content">
						<button type="button" class="btn btn-primary pull-right" onclick="PlaySelectRecord()">播放选中视频</button>
						<button type="button" class="btn pull-right" onclick="SelectAllRecord()">全部选择</button>
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th>#</th>
									  <th>开始时间</th>
									  <th>结束时间</th>
									  <th>大小</th>   
									  <th>选择</th>    
									  <th>操作</th>                                          
								  </tr>
							  </thead>   
							  <tbody >
							  </tbody>
						 </table>  
					</div>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>

<script type="text/javascript">
<!--

$(function () {

	$._messengerDefaults = {
			maxMessages:5,
			extraClasses: 'messenger-fixed messenger-theme-future messenger-on-bottom messenger-on-left'
	};
	
	$("#menu-recorder").addClass("active");
	//$("#movie1").hide();
	setDivMode(202);

	//08平台自动获取设备列表，P2P需要主动获取
	if(CENTER_SVR_TYPE == 1){
		OwnDevRefresh();
	}
	
	$("#form_recordQuery").validate({
		rules: {
			startTime:"required",
			endTime:"required",
			recordType:"required",
			mydevice:"required"
				},
		messages: {
			startTime:"请输入录像开始时间",
			endTime:"请输入录像结束时间",
			recordType:"请输入查询录像类型",
			mydevice:"请选择需要查询的设备"
				},
		submitHandler: function(form){  
			return QueryRecordFileList();
		}
	});
	
	var currentDate = new Date();
	currentDate.setHours(0,0,0);
	$("#startTime").datetimepicker('setDate', currentDate );
	currentDate.setHours(23,59,59);
	$("#endTime").datetimepicker('setDate', currentDate );

	$.scrollUp();
	
	
});

function OwnDevRefresh()
{
	$.ajax({
		type: 'POST',
		url: BASE_URL+'command/OwnDeviceList',
		dataType: 'json',
		data:"",
		success: function (data) {
			$("#mydevice option").remove();
			xmlDoc = loadXMLString(data);
			x=xmlDoc.getElementsByTagName("Info");
			for (var i=0;i<x.length;i++)
		  	{ 
				var NodeName = x[i].getAttribute("N");
				var NodeID = x[i].getAttribute("ID")*256+1;
				var online = x[i].getAttribute("S");
				if(online == 1)	
				{
					$("#mydevice").append("<option value="+NodeID+">"+NodeName+"</option>");
				}
		  	}
		},
		error: function () {
			AlertMessage("获取拥有设备列表"+"操作失败","error");
		}
	});
}

function QueryRecordFileList()
{
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","error");
		return false;
	}
	//var devID = $("#mydevice").find("option:selected").val();
	var startTime=new Date($("#startTime").datetimepicker("getDate"));
	var endTime = new Date($("#endTime").datetimepicker("getDate"));
	var camID = $("#mydevice option:selected").val();
	//camID = camID*256+1;
	//var retStr = player.QueryRecordFileList(camID,startTime.getTime()/1000,endTime.getTime()/1000,1);

	var target = $("#recordType option:selected").val();
	
	var params = {startTime:startTime.getTime()/1000,
			endTime:endTime.getTime()/1000,
			fileType:0,
			targetType:parseInt(target)
	};
	var paramStr = JSON.stringify(params);
	
	var retStr = player.QueryRecordFileList2(camID,paramStr);
	
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		AlertMessage("操作成功","success");
		g_cameraID = camID;
		var fileArray = obj.fileList;
		$("#recordFileList tbody").empty();
		InsertRecordTable(fileArray);
		
		location.href = "#recordFileList";
		
	} else {
		AlertMessage("操作失败-"+obj.retDes,"error");
	}
	return true;
}

function InsertRecordTable(fileArray)
{
	var x;
	for(x in fileArray)
	{
		var sd=new Date(fileArray[x].startTime*1000);
		var ss = (sd.getMonth()+1)+"/"+sd.getDate()+"/"+sd.getFullYear()+
		" "+sd.getHours()+":"+sd.getMinutes()+":"+sd.getSeconds();
		var ed=new Date(fileArray[x].endTime*1000);
		var es = (ed.getMonth()+1)+"/"+ed.getDate()+"/"+ed.getFullYear()+
		" "+ed.getHours()+":"+ed.getMinutes()+":"+ed.getSeconds();
		
		$("#recordFileList tbody").append("<tr><td>"+fileArray[x].fileNo+
				"</td><td>"+ss+"</td><td>"+es+"</td><td>"+
				fileArray[x].fileSize+"</td><td><input type='checkbox' onchange='toggleCheckbox(this)'></td>"+
			"<td><a class='label label-success' onclick='PlayRecord(this)' fileNo="+
			fileArray[x].fileNo+">播放录像</a></td></tr>");
		fileArray[x]
	}
}

function PlayRecord(element)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","error");
		return false;
	}
	var fileNo = $(element).attr('fileNo');
	player.PlayRemoteRecord(g_cameraID,-1);
	var retStr = player.PlayRemoteRecord(g_cameraID,fileNo);
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		AlertMessage("播放录像成功","success");
	} else {
		AlertMessage("播放录像失败-"+obj.retDes,"error");
	}
	location.href = "#movie1";
	
	return true;	
}
function SelectAllRecord()
{
	$("#recordFileList tbody").find(':checkbox').attr("checked",true);
	//$("#recordFileList tbody").find(':checkbox').val(1);
//	$(":checkbox").attr("checked",element.checked);
//	$(":checkbox").val(1);
}
function PlaySelectRecord()
{
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","error");
		return false;
	}
	var retStr = null;
	
	
	$("#recordFileList tbody").find(':checkbox').each(function(){
			if($(this).attr('checked')){
				var tdText = $(this).parent().parent().children().first().text();
				var fileNo = parseInt(tdText);
				if(retStr==null){
					player.PlayRemoteRecord(g_cameraID,-1);
					retStr = player.PlayRemoteRecord(g_cameraID,fileNo);
				}else{
					player.PlayRemoteRecord(g_cameraID,fileNo);
				}
			}
		});
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		AlertMessage("播放录像成功","success");
	} else {
		AlertMessage("播放录像失败-"+obj.retDes,"error");
	}
	location.href = "#movie1";
}
//-->
</script>