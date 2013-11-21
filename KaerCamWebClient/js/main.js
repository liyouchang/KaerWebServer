jQuery(document).ready(function($) {

    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
    });
    
    $('ul.nav li.dropdown').click(function () {
    	$(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut();
    });
  //####### Menu
    $("#menu").menu();
    //$("#menu").menu("destroy");
    //ajaxify menus
	$('a.ajax-link').click(function(e){
		if( $(this).parent().hasClass('active')) return;
		var $clink=$(this);
		var addr = $clink.attr('rel');
		if(!addr) {return;}
		e.preventDefault();
		$('#loading').remove();
		//$('#content').fadeOut().parent().append('<div id="loading" class="center">Loading...<div class="center"></div></div>');
		doAjaxLoad(addr);
		//$('#content').load(addr+" #content-inner");
		//docReady();
		//$('#loading').remove();
		$('ul.main-menu li.active').removeClass('active');
		$clink.parent('li').addClass('active');	
		$clink.closest('li.dropdown').addClass('active');
		$clink.trigger('activate');
	});

	//DevRefresh();
});

function doAjaxLoad(addr)
{
	$.ajax({
		url:addr,
		dataType:"html",
		beforeSend:function(){
			//这里使用fadeout会没有效果
			$('#content').hide().parent().append('<div id="loading" class="center">Loading...<div class="center"></div></div>');
		},
		complete:function(){
			$('#loading').remove();
		},
		success:function(msg){
			$('#content').html(jQuery("<div>").append($.parseHTML(msg)).find('#content').html());
			docReady();
			$('#content').fadeIn();
		}
	});
}

function XMLTree(data,pid)
{
	var xmlDoc = loadXMLString(data);
	var x=xmlDoc.getElementsByTagName("Info");
	var treeObj = $.fn.zTree.getZTreeObj("treeDemo");	
	var parentNode = treeObj.getNodeByParam("id", pid, null);
	treeObj.removeChildNodes(parentNode);
	for (var i=0;i<x.length;i++)
  	{ 
		var NodeName = x[i].getAttribute("N");
		var NodeID = x[i].getAttribute("ID");
		var online = x[i].getAttribute("S");
		//var mac = x[i].getAttribute("D");
		var icon = (online==1)?"encoder":"encoderOffline";
		var newNode = {id:NodeID, pId:pid, name:NodeName, status:online, iconSkin:icon};
		treeObj.addNodes(parentNode,newNode);
  	}
	
}
function changeAlertMsg(info,error)
{
	$("#alert-message").removeClass("alert-info alert-error alert-success");
	$("#alert-message").addClass(error);
	$("#alert-message").text(info);
}

function AlertMessage(info,type)
{
	$.globalMessenger().post({ 
		message: info,
	    type: type,
	    showCloseButton: true
	    });
   
}
function toggleCheckbox(element)
{
	$(element).attr("checked",element.checked);
	$(element).val(1);
}

//播放视频
function StartRTVideo(cameraID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","info");
		return false;
	}
	var ret = player.StartRealTimeVideo(cameraID);
	var obj = JSON.parse(ret);
	if(obj.retValue != 13){
		AlertMessage("开始实时视频失败，"+obj.retDes,"error");
		return false;
	}
	SetControlPTZ(1);
	AlertMessage("开始实时视频成功","success");
	return true;	
}
function SetDevRecord()
{
	//录像
	var recordStart = 0;
	var snapStart = 0;
	if($("#recordCheck").attr("checked"))
		recordStart = 1;
	if($("#snapCheck").attr("checked"))
		snapStart = 1;
	$.ajax({
		type: 'POST',
		url: BASE_URL+'command/set_dev_record',
		dataType: 'json',
		data:{dev_id:g_selectTreeNode.id,type:0,start:recordStart},
		success: function (data) {
			if (data.errorCode == "0d")
				AlertMessage("设置录像参数-"+data.errorDesc,"success"); 			
			else
				AlertMessage("设置录像参数-"+data.errorDesc,"error");
		},
		error: function () {
			AlertMessage("设置录像参数-"+"操作失败","error");
		},
		complete:function(){
			//抓拍
//			
//			$.ajax({
//				type: 'POST',
//				url: BASE_URL+'command/set_dev_record',
//				dataType: 'json',
//				data:{dev_id:g_selectTreeNode.id, type:1, start:snapStart},
//				success: function (data) {
//					if (data.errorCode == "0d") 
//						AlertMessage("设置抓拍参数-"+data.errorDesc,"success"); 	
//					else
//						AlertMessage("设置抓拍参数-"+data.errorDesc,"error");			
//				},
//				error: function () {
//					AlertMessage("设置抓拍参数-"+"操作失败","error");
//				}
//			});	
		}
		
	});	
	
}
function GetDevRecordParam()
{
	//获取录像
	var selectedVal;
	$.ajax({
		type: 'POST',
		url: BASE_URL+'command/get_dev_record',
		dataType: 'json',
		data:{dev_id:g_selectTreeNode.id,type:0},
		success: function (data) {
			if (data.errorCode == "0d")
				$("#recordCheck").attr("checked",!!data.status); 			
			else
				AlertMessage("获取录像参数失败-"+data.errorDesc,"error");
		},
		error: function () {
			AlertMessage("获取录像参数-"+"操作失败","error");
		},
		complete:function(){
			//抓拍
//			$.ajax({
//				type: 'POST',
//				url: BASE_URL+'command/get_dev_record',
//				dataType: 'json',
//				data:{dev_id:g_selectTreeNode.id,type:1},
//				success: function (data) {
//					if (data.errorCode == "0d") 
//						$("#snapCheck").attr("checked",!!data.status); 	
//					else
//						AlertMessage("获取抓拍参数失败-"+data.errorDesc,"error");			
//				},
//				error: function () {
//					AlertMessage("获取抓拍参数-"+"操作失败","error");
//				}
//			});	
		}
	});	
	
}
function GetShrUser(){
	$("#modal_cancelShr_alert").empty();
	$.ajax({
		type: 'POST',
		url: BASE_URL+'command/check_share_user',
		dataType: 'json',
		data:{dev_id:g_selectTreeNode.id},
		success: function (data) {
			//alert(data);
			xmlDoc = loadXMLString(data);
			x=xmlDoc.getElementsByTagName("Info");
			for (var i=0;i<x.length;i++)
		  	{ 
				var devID = x[i].getAttribute("D");
				var userID = x[i].getAttribute("U");
				var userName = x[i].getAttribute("N");
				$("#modal_cancelShr_alert").append(
					"<label class='checkbox checkbox_add ' devID="+devID+
					" UserID="+userID+"><input type='checkbox' onchange='toggleCheckbox(this)'>"+
					userName+"</label>"
				);
		  	}
		},
		error: function () {
			AlertMessage("获取设备共享用户"+"操作失败","error");
		}
	});	
}

function CancelShare(){
	$("#modal_cancelShr_alert .checkbox_add").each(function(){
		if($(this).children(":checkbox").attr("checked")){
			var userName = $(this).text();
			$.ajax({
				type: 'POST',
				url: BASE_URL+'command/cancel_share',
				dataType: 'json',
				data:{dev_id:$(this).attr("devID"),shr_user:$(this).attr("UserID")},
				success: function (data) {
					if (data.errorCode == "0d") {
						AlertMessage("删除共享用户"+userName+data.errorDesc,"success");			
					}
					else
					{
						AlertMessage("删除共享用户"+userName+"失败："+data.errorDesc,"error");			
					}
				},
				error: function () {
					AlertMessage("删除共享用户"+userName+"操作失败","error");
				}
			});	
			//alert($(this).attr("devID"));
		}
	  });
}
function AddCamera(){
	//ModalPrependInfo("","alert-info");
	var valid = $("#form_addCam").valid();
	if(valid){
		//$('#model_addCam').modal('hide');
		var params = {cam_id:$("#addDeviceID").val() ,device_name:$("#addDeviceName").val()};
		$.ajax({
			type: 'POST',
			url: BASE_URL+'command/add_camera',
			dataType: 'json',
			data:params,
			success: function (data) {
				if (data.errorCode == "0d") {
					ModalPrependInfo(data.errorDesc,"alert-success");
					DevRefresh();
				}
				else
				{
					ModalPrependInfo(data.errorDesc,"alert-error");
				}
			},
			error: function () {
				ModalPrependInfo("操作失败","alert-error");
			}
		});
	}	
};
function ChgDevName(){
	var valid = $("#form_chgDevName").valid();
	if(valid){
		//$('#model_addCam').modal('hide');
		var params = {devID:g_selectTreeNode.id ,devName:$("#newDeviceName").val()};
		$.ajax({
			type: 'POST',
			url: BASE_URL+'command/change_device_name',
			dataType: 'json',
			data:params,
			success: function (data) {
				if (data.errorCode == "0d") {
					ModalPrependInfo(data.errorDesc,"alert-success");			
				}
				else
				{
					ModalPrependInfo(data.errorDesc,"alert-error");
				}
			},
			error: function () {
				ModalPrependInfo("操作失败","alert-error");
			}
		});
	}	
}
function ShrCamera(){
	//ModalPrependInfo("","alert-info");
	var valid = $("#form_shrCam").valid();
	if(valid){
		//$('#model_addCam').modal('hide');
		var params = {user_name:$("#shr_user_name").val() ,cam_id:g_selectTreeNode.id};
		$.ajax({
			type: 'POST',
			url: BASE_URL+'command/shr_camera',
			dataType: 'json',
			data:params,
			success: function (data) {
				if (data.errorCode == "0d") {
					ModalPrependInfo(data.errorDesc,"alert-success");			
				}
				else{
					ModalPrependInfo(data.errorDesc,"alert-error");
				}
			},
			error: function () {
				ModalPrependInfo("操作失败","alert-error");
			}
		});
	}
};

function DelCamera(type)
{
	var type;
	if(g_selectTreeNode.pId == OwnListTreeID){
		type = 12;
	}
	if(g_selectTreeNode.pId == ShrListTreeID){
		type = 13;
	}
	var params = {cam_id:g_selectTreeNode.id,del_type:type};
	$.ajax({
		type: 'POST',
		url: BASE_URL+'command/del_camera',
		dataType: 'json',
		data:params,
		success: function (data) {
			if (data.errorCode == "0d") {
				AlertMessage(data.errorDesc,"success");
				DevRefresh();							
			}
			else{
				AlertMessage(data.errorDesc,"error");
				//ModalPrependInfo("删除设备-"+data.errorDesc,"alert-error");
			}
		},
		error: function () {
			AlertMessage("操作失败","error");
			//ModalPrependInfo("操作失败","alert-error");
		}
	});
}
function ModalPrependInfo(info,type)
{
	$(".alert_add").alert("close");
	$(".modal-body").prepend(
		"<div id='modal_alert' class=' alert_add alert "+type+"'>"+
		"<button type='button' class='close' data-dismiss='alert'>&times;</button>"+
		info+"</div>"
	);
	//$("#modal_alert").addClass(type);
	//$("#modal_alert").text(info);
}


function DevRefresh()
{
	$.ajax({
		type: 'POST',
		url: BASE_URL+'command/OwnDeviceList',
		dataType: 'json',
		data:"",
		success: function (data) {
			XMLTree(data,OwnListTreeID);
		},
		error: function () {
			AlertMessage("获取拥有设备列表"+"操作失败","error");
		},
		complete:function(){
			$.ajax({
				type: 'POST',
				url: BASE_URL+'command/ShrDeviceList',
				dataType: 'json',
				data:"",
				success: function (data) {
					XMLTree(data,ShrListTreeID);
				},
				error: function () {
					AlertMessage("获取共享设备列表"+"操作失败","error");
				}
			});
		}
	});	
}

function GetWifi()
{
	ShowApList();
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}

	var retStr = player.GetDevWifiAP(g_cameraID);
	//alert(retStr);
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		
		AlertMessage("刷新网络成功","success");
		$("#model_SetWifi tbody").empty();
		var apArray = obj.apList;
		InsertAPListTable(apArray);
	} else {
		AlertMessage("刷新网络失败-"+obj.retDes,"error");
	}
}


function InsertAPListTable(apArray)
{
	var x;
	for(x in apArray)
	{	
		var encryptStr;
		switch(apArray[x].encryptType)
		{
		case 0:encryptStr="无";break;
		case 1:encryptStr="WEP";break;
		case 2:encryptStr="WPA-PSK";break;
		case 3:encryptStr="WPA2-PSK";break;
		}
				
		
		$("#model_SetWifi tbody").append("<tr><td>"+apArray[x].listNo+
				"</td><td>"+apArray[x].essid+"</td><td>"+encryptStr+
				"</td><td><a class='badge badge-important' onclick='SetWifi(this)' listNo="+
			apArray[x].listNo+">使用</a></td></tr>");
	}
}
function ShowApList()
{
	$('#model_SetWifi form').hide();
	$('#model_SetWifi table').show();
}
function SetWifi(element)
{
	$('#model_SetWifi form').show();
	$('#model_SetWifi table').hide();
	
	$("#wifiListNo").val( $(element).attr('listNo'));
	
}
function SetWifiParam()
{
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","error");
		return false;
	}
	var pppoeUseVal = 0;
	if($("#pppoeCheck").attr("checked"))
		pppoeUseVal = 1;
	var wifiListNo = parseInt($('#wifiListNo').val());
	var params = {listNo:wifiListNo,
			wifiPwd:$('#wifiPwd').val(),
			pppoeUse:pppoeUseVal,
			pppoeName:$('#pppoeName').val(),
			pppoePwd:$('#pppoePwd').val()
			};
	var paramStr = JSON.stringify(params);
	var retStr = player.SetDevWifiAP(g_cameraID,paramStr);
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		AlertMessage("设置wifi参数成功","success");
	} else {
		AlertMessage("设置wifi参数失败-"+obj.retDes,"error");
	}
	return true;
}
function GetVideoParam(){
	$("input[name='frameRadios']").attr("checked", false);
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	$.ajax({
		type: 'POST',
		url:'' ,
		dataType: 'json',
		data:"",
		complete:function(){
			var retStr = player.GetVideoParam(g_cameraID);
			//alert(retStr);
			var obj = JSON.parse(retStr);
			if (obj.retValue == 13) {
				AlertMessage("获取设备视频参数成功","success");
				var format = obj.videoFormat;
				$("input[name='frameRadios'][value="+format+"]").click();
			} else {
				AlertMessage("获取设备视频参数失败-"+obj.retDes,"error");
			}
		}
	});	
	
}
function SetVideoParam()
{
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","error");
		return false;
	}
	var format = parseInt($("input[name='frameRadios']:checked").val());
	alert(format);
	var params = {videoFormat:format};
	var paramStr = JSON.stringify(params);
	var retStr = player.SetVideoParam(g_cameraID,paramStr);
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		AlertMessage("设置设备视频参数成功","success");
	} else {
		AlertMessage("设置设备视频参数失败-"+obj.retDes,"error");
	}
	return true;
}