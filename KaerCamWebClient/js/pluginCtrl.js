
var IDMark_Switch = "_switch",
		IDMark_Icon = "_ico",
		IDMark_Span = "_span",
		IDMark_Input = "_input",
		IDMark_Check = "_check",
		IDMark_Edit = "_edit",
		IDMark_Remove = "_remove",
		IDMark_Ul = "_ul",
		IDMark_A = "_a";

var OwnListTreeID = 100000,
	ShrListTreeID = 200000;

var setting = {
	data : {
		simpleData : {
			enable : true
		}
	},
	view : {
		// fontCss: getFontCss,
		selectedMulti : true
		//addHoverDom: addHoverDom,
		//removeHoverDom: removeHoverDom
	},
	callback : {
		onDblClick : zTreeOnDblClick,
		onClick: zTreeOnClick
	}
};

function showRMenu(type, x, y) {
	$("#rMenu ul").show();
	$("#rMenu ul li").show();
	if(type=="owndevmenu"){
		if(g_selectTreeNode.status == 0){
			$("#rMenu ul  li").hide();
			$("#m_DelShrDev").show();
			$("#m_DelDev").show();
		}
	}
	if(type=="shrdevmenu"){
		$("#rMenu ul  li").hide();
		if(g_selectTreeNode.status == 1){
			$("#m_RTVideo").show();
			if(SHARE_PERMISSION == 1){//如果共享设备也有权限，测试时使用
				$("#m_SetWifi").show();
				$("#m_SetParam").show();
			}	
		}
		$("#m_DelDev").show();
		
	}
	$("#rMenu").css({"top":y+"px", "left":x+"px"});
	//$( "#menu" ).menu( "collapseAll", null, true );
	$("#rMenu").fadeIn("fast");
	$("body").bind("mousedown", onBodyMouseDown);
};

function hideRMenu() {
	$("#rMenu").stop();
	$("#rMenu").fadeOut("fast");
	$("body").unbind("mousedown", onBodyMouseDown);
};
function onBodyMouseDown(event){
	hideRMenu();
	//if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length>0)) {
	//	hideRMenu();
	//}
};

function zTreeOnClick(event, treeId, treeNode) {
	hideRMenu();
	var selector = "#"+treeNode.tId+IDMark_Span;
	var x = $(selector).offset().left + $(selector).width();
	var y = $(selector).offset().top;
	g_selectTreeNode = treeNode;
	
	if(treeNode.pId == OwnListTreeID){
		g_cameraID = treeNode.id*256+1;
		showRMenu("owndevmenu",x,y);
	}
	if(treeNode.pId == ShrListTreeID){
		g_cameraID = treeNode.id*256+1;
		showRMenu("shrdevmenu",x,y);
	}
};

// 双击节点打开视频
function zTreeOnDblClick(event, treeId, treeNode) {
	if(treeNode){
		var isParent = treeNode.isParent;
		if (!isParent && treeNode.toPlay) {
			
			StartRTVideo(treeNode.id);
		}
	}
};

var zNodes = [ 
	{id : OwnListTreeID,pId : 0,name : "拥有摄像头列表",open : true,iconSkin : "home"},
    {id : ShrListTreeID,pId : 0,name : "共享摄像头列表",open : true,iconSkin : "home"}
];

var nodeList = [];
var lastValue = "";

// 查询节点，选中查询到的节点
function searchCamera() {
	var zTree = $.fn.zTree.getZTreeObj("treeDemo");
	var keyType = "name";
	var value = $.trim($("#camKey").get(0).value);
	// if (lastValue === value) return;
	// lastValue = value;

	if (value === "") {
		// zTree.cancelSelectedNode();
		return;
	}

	// updateNodes(false);
	nodeList = zTree.getNodesByParamFuzzy(keyType, value);

	zTree.cancelSelectedNode();
	// zTree.expandAll(false);
	for ( var i = 0, l = nodeList.length; i < l; i++) {
		// nodeList[i].highlight = highlight;
		// zTree.updateNode(nodeList[i]);
		zTree.selectNode(nodeList[i], true);
	}
}

function IsShareCamera(cameraID)
{
	var devID = cameraID>>8;
	var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
	var node = treeObj.getNodeByParam("id", devID, null);
	if(node != null && node.pId == ShrListTreeID)
		return true;
	return false;
}


// camera control pannel functions
function MM_swapImgRestore(id, cs1, cs2) {
	if ($("#" + id).hasClass(cs2)) {
		$("#" + id).removeClass(cs2);
	}
	if (!$("#" + id).hasClass(cs1)) {
		$("#" + id).addClass(cs1);
	}
}
function MM_swapImage(id, cs1, cs2) {
	if($("#" + id).hasClass(cs1)) {
		$("#" + id).removeClass(cs1);
	}
	if(!$("#" + id).hasClass(cs2)){
		$("#" + id).addClass(cs2);
	}
}
// 控制带云台操作的播放窗口的展示
function advancedOption() {
	if ($("#advancedoption").css("display") == "none") {
		$("#advancedoption").css("display", "block");
		// $("#controlAdvancedIcon").css("class","active icon icon-color
		// icon-arrowstop-n");
		$("#hidemore").text('收起更多操作');
	} else {
		$("#advancedoption").css("display", "none");
		// $("#controlAdvancedIcon").css("class","active icon icon-color
		// icon-arrowstop-s");
		$("#hidemore").text('展开更多操作');
	}
}

function ViewTree(bView) {
	var player = document.getElementById("player");

	if ($("#viewTree").text() == "显示树形列表") {

		$("#viewTree").text("隐藏树形列表");
		player.IsViewTree(1);
	} else {
		$("#viewTree").text("显示树形列表");
		player.IsViewTree(0);
	}
}

function setDivMode(value) {
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	player.SetDivision(value);
	return true;
}

// 成功登录标记
var login = false;
// 是否安装插件
var hasplug = true;

function DetectActiveX()
{
	   try
	   {
	      //var comActiveX = new ActiveXObject("Ke2008WebProj1.Ke2008Web");   
		   var comActiveX = new ActiveXObject("KEWEBCAMOCX.KeWebCamOCXCtrl.1");
	   }
	   catch(e)
	   {
		      return false;
	   }
	    return true;
}
// 页面初始化插件对象,适合多浏览器支持
function initObject1() {
	var result = false;
	if ($.browser.msie) {browseFlag = 1;} 
	else if ($.browser.safari) {browseFlag = 2;}
	else if ($.browser.mozilla) {browseFlag = 2;}
	else if ($.browser.opera) {browseFlag = 2;}
	else if ($.browser.chrome) {browseFlag = 2;}
	else {	browseFlag = 2;}
	
	// 如果是ie
	if (browseFlag == 1) {
		// $("#movie1").append("<OBJECT id='player'
		// CLASSID=\"clsid:9E89FD56-D8A5-4E04-97DF-8C4D670CAE74\" width=100%
		// height=100%></OBJECT>");
		$("#movie1").append("<OBJECT id='player' " +
				"CLASSID=\"clsid:F4418F4B-4A6B-4A93-948F-332025F395E8\" " +
				"width=100% height=100%></OBJECT>");
		 if(DetectActiveX())
		 {
			 result = true;
		}else
		{
			result=false;
		}
	} else {
		result = false;
	}
	return result;
}

function InitPlayer(){
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var client_id = $.cookie('clientID');
	
	player.InitailCtrl(1);
	
	var Addr =CENTER_SVR_IP;
	var Port = 22616;
	var retStr = player.ConnectServer(Addr,Port,client_id);
	if (retStr == ""){
		AlertMessage("检测到新版本播放插件,请点击<a href="+PLUGIN_FILE_PATH+">这里</a>下载","info");
		return false;
	}
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		login = true;
		$("#infoText").text("初始化成功");
		retStr = player.CheckVersion();
		obj = JSON.parse(retStr);
		if(obj.update == true){
			AlertMessage("检测到新版本播放插件,请点击<a href="+PLUGIN_FILE_PATH+">这里</a>下载","info");
		}
	} else {
		login = false;
		AlertMessage("初始化失败"+obj.retDes,"error");
	}
	
}
function InitPlayer08(){
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	
	player.InitailCtrl(2);//初始化为08平台
	var Addr =CENTER_SVR_IP;
	var Port = 22616;
	var retStr = player.ConnectServer(Addr,Port,0);//08平台登录
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		//登录 08平台需要登录，无需检测插件版本
		loginServer();
	} else {
		login = false;
		$("#infoText").text("初始化失败"+obj.retDes);
	}
}


// 登录播放插件
function loginServer() {
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var IVS_User = $.cookie('LoginName'), IVS_Psw = $.cookie('LoginPwd');

	var retStr = player.LoginServer(IVS_User, IVS_Psw);
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		login = true;
		$("#infoText").text("登录成功");
	} else {
		login = false;
		$("#infoText").text("登陆失败"+obj.retDes);
	}
}
function initPlugin() {
	if (initObject1()) {
		if(CENTER_SVR_TYPE == 1){
			InitPlayer();
		}else{
			InitPlayer08();
		}
			
	} else {// 未安装插件提示
		AlertMessage("播放插件未安装,请点击<a href="+PLUGIN_FILE_PATH+">这里</a>下载","info");
		hasplug = false;
		$("#infoText").text("监控插件未安装！");
	}
	//advancedOption();不打开更多操作
	//TODO:08 is set to null
	if(CENTER_SVR_TYPE == 1){
		$.fn.zTree.init($("#treeDemo"), setting, zNodes);
	}else{
		$.fn.zTree.init($("#treeDemo"), setting, null);
	}
	//$.fn.zTree.init($("#treeDemo"), setting, zNodes);

}


// 退出时先注销插件
function logout() {
	if (!hasplug) {
		// document.URL = "/cwmp/logout.jsp";
	} else {
		if (login == true) {
			var player = document.getElementById("player");
			player.LogOut();

		} else {
			$("#infoText").text("插件正在登录，请稍后再试 ");
		}
	}
}

//判断元素是否绑定了事件
function isBindEvent(id,event)
{
	
	//var tempE = $("#"+id).data("events");
	var tempE = $.data(("#"+id),"events");
	
	if(tempE)
	{
		if(tempE[event])
		{
			return true;
		} else
		{
			return false;
		}
	} else
	{
		return false;
	}
}

function SnapPic(camID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var retStr = player.TakeSnapshot(camID);
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		//$("#infoText").text("抓拍成功："+ obj.filePath);
		AlertMessage("抓拍成功："+ obj.filePath,"success");
	} else {
		//$("#infoText").text("抓拍失败："+obj.retDes);
		AlertMessage("抓拍失败："+ obj.filePath,"error");
	}

	return true;
}
function StartRecord(camID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var retStr = player.StartRecord(camID);
	var obj = JSON.parse(retStr);
	if (obj.retValue == 13) {
		//$("#infoText").text("开始录像成功："+ obj.filePath);
		AlertMessage("开始录像成功："+ obj.filePath,"success");
	} else {
		//$("#infoText").text("开始录像失败："+obj.retDes);
		AlertMessage("开始录像失败："+obj.retDes,"error");
	}
	return true;
}
function StopRecord(camID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var ret = player.StopRecord(camID);
	var obj = eval("("+ret+")");
	if (obj.retValue == 13) {
		$("#infoText").text("停止录像成功");
		
	} else {
		$("#infoText").text("停止录像失败："+obj.retDes);
	}
	return true;
}
function StartListen(camID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var ret = player.StartRealTimeAudio(camID);
	var obj = eval("("+ret+")");
	if (obj.retValue == 13) {
		$("#infoText").text("开始监听成功");
	} else {
		$("#infoText").text("开始监听失败："+obj.retDes);
	}
	return true;
}
function StopListen(camID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var ret = player.StopRealTimeAudio(camID);
	var obj = eval("("+ret+")");
	if (obj.retValue == 13) {
		$("#infoText").text("停止监听成功");
	} else {
		$("#infoText").text("停止监听失败："+obj.retDes);
	}
	return true;
}
function StartTalk(camID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var ret = player.StartAudioTalk(camID);
	var obj = eval("("+ret+")");
	if (obj.retValue == 13) {
		$("#infoText").text("开始通话成功");
	} else {
		$("#infoText").text("开始通话失败："+obj.retDes);
	}
	return true;
}
function StopTalk(camID)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	var ret = player.StopAudioTalk(camID);
	var obj = eval("("+ret+")");
	if (obj.retValue == 13) {
		$("#infoText").text("停止通话成功");
	} else {
		$("#infoText").text("停止通话失败："+obj.retDes);
	}
	return true;
}
function ControlPTZ(cmd,speed,data)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		return false;
	}
	player.ControlPTZ(0,cmd,speed,data);
	return true;
}

//控制云台、聚焦、步长等
function SetControlPTZ(flag) {
	if (flag == 0) {
		if (g_enablePannel == 0) {
			return;
		}
		g_enablePannel = 0;
		MM_swapImage("direction02", "direction_02", "udirection_02");
		$("#linkDir02").unbind("mousedown");
		$("#linkDir02").unbind("mouseup");

		MM_swapImage("direction04", "direction_04", "udirection_04");
		$("#linkDir04").unbind("mousedown");
		$("#linkDir04").unbind("mouseup");

		MM_swapImage("direction05", "direction_05", "udirection_05");
		$("#linkDir05").unbind("click");

		MM_swapImage("direction06", "direction_06", "udirection_06");
		$("#linkDir06").unbind("mousedown");
		$("#linkDir06").unbind("mouseup");

		MM_swapImage("direction08", "direction_08", "udirection_08");
		$("#linkDir08").unbind("mousedown");
		$("#linkDir08").unbind("mouseup");

		MM_swapImage("iconforcus", "icon_forcus", "uicon_forcus");
		$("#iconforcus").unbind("click");

		MM_swapImage("iconreduce", "icon_reduce", "uicon_reduce");
		$("#linkiconr").unbind("click");

		MM_swapImage("iconadd", "icon_add", "uicon_add");
		$("#linkicona").unbind("click");

		MM_swapImage("iconquan", "icon_quan", "uicon_quan");
		$("#iconquan").unbind("click");

		MM_swapImage("iconreducequan", "icon_reduce", "uicon_reduce");
		$("#linkiconrq").unbind("mousedown");
		$("#linkiconrq").unbind("mouseup");

		MM_swapImage("iconaddquan", "icon_add", "uicon_add");
		$("#linkiconaq").unbind("mousedown");
		$("#linkiconaq").unbind("mouseup");

		MM_swapImage("iconreducefocus", "icon_reduce", "uicon_reduce");
		$("#linkiconrz").unbind("mousedown");
		$("#linkiconrz").unbind("mouseup");

		MM_swapImage("iconaddfocus", "icon_add", "uicon_add");
		$("#linkiconaz").unbind("mousedown");
		$("#linkiconaz").unbind("mouseup");

		MM_swapImage("iconfocus", "icon_zoom", "uicon_zoom");
		$("#iconfocus").unbind("click");

		MM_swapImage("stepsatus","step_status_"+g_speed,"ustep_status_"+g_speed);
		MM_swapImage("linkbtnl", "btn_large_on", "ubtn_large_on");
		$("#linkbtnl").unbind("click");
		MM_swapImage("linkbtns", "btn_small_on", "ubtn_small_on");
		$("#linkbtns").unbind("click");
		
		//控制语音通讯
		MM_swapImage("telopen","tel_open","utel_open");
		$("#linktelo").unbind("click");
		MM_swapImage("telclose","tel_close","utel_close");
		$("#linktelc").unbind("click");
		//控制广播
		MM_swapImage("boardopen","board_open","uboard_open");
		$("#linkboardo").unbind("click");
		MM_swapImage("boardclose","board_close","uboard_close");
		$("#linkboardc").unbind("click");
		//控制录像
		MM_swapImage("recopen","rec_open","urec_open");
		$("#linkreco").unbind("click");
		MM_swapImage("recclose","rec_close","urec_close");
		$("#linkrecc").unbind("click");
		
		//抓拍
		MM_swapImage("zpopen","zp_open","uzp_open");
		$("#zpopen").unbind("click");
		
	} else {
		if (g_enablePannel == 1) {
			return;
		}
		g_enablePannel = 1;
		
		if(IsShareCamera(g_cameraID) && SHARE_PERMISSION != 1)//共享摄像头可以进行的操作
		{

			//控制监听
			MM_swapImgRestore("boardopen","board_open","uboard_open");
			$("#linkboardo").click(function(){
				StartListen(0);
			});
			MM_swapImgRestore("boardclose","board_close","uboard_close");
			$("#linkboardc").click(function(){
				StopListen(0);
			});
			
			//控制录像
			MM_swapImgRestore("recopen","rec_open","urec_open");
			$("#linkreco").click(function(){
				StartRecord(0);
			});
			MM_swapImgRestore("recclose","rec_close","urec_close");
			$("#linkrecc").click(function(){
				StopRecord(0);
			});
			
			//抓拍
			MM_swapImgRestore("zpopen","zp_open","uzp_open");
			$("#zpopen").click(function(){
				SnapPic(0);
			});
			return;
		}
		// up
		MM_swapImgRestore("direction02", "direction_02", "udirection_02");
		$("#linkDir02").mousedown(function() {
			var speed = g_speed * 62 / 5 + 1;// 1~63
			ControlPTZ(0, speed, speed);
		});
		$("#linkDir02").mouseup(function() {
			ControlPTZ(19, 0, 0);
		});
		
		// left
		MM_swapImgRestore("direction04", "direction_04", "udirection_04");
		$("#linkDir04").mousedown(function() {
			var speed = g_speed * 62 / 5 + 1;// 1~63
			ControlPTZ(2, speed, speed);
		});
		$("#linkDir04").mouseup(function() {
			ControlPTZ(19, 0, 0);
		});

		// Right
		MM_swapImgRestore("direction06", "direction_06", "udirection_06");
		$("#linkDir06").mousedown(function() {
			var speed = g_speed * 62 / 5 + 1;// 1~63
			ControlPTZ(3, speed, speed);
		});
		$("#linkDir06").mouseup(function() {
			ControlPTZ(19, 0, 0);
		});

		// down
		MM_swapImgRestore("direction08", "direction_08", "udirection_08");
		$("#linkDir08").mousedown(function() {
			var speed = g_speed * 62 / 5 + 1;// 1~63
			ControlPTZ(1, speed, speed);
		});
		$("#linkDir08").mouseup(function() {
			ControlPTZ(19, 0, 0);
		});

		// auto自动云台
		MM_swapImgRestore("direction05", "direction_05", "udirection_05");
		$("#linkDir05").click(function() {
			AutoYuntai();
		});

		// 光圈
		MM_swapImgRestore("iconforcus", "icon_forcus", "uicon_forcus");
		MM_swapImgRestore("iconreduce", "icon_reduce", "uicon_reduce");
		$("#linkiconr").click(function() {
			ControlPTZ(5, 0, 0);
		});
		MM_swapImgRestore("iconadd", "icon_add", "uicon_add");
		$("#linkicona").click(function() {
			ControlPTZ(4, 0, 0);
		});

		// 焦距
		MM_swapImgRestore("iconquan", "icon_quan", "uicon_quan");
		MM_swapImgRestore("iconreducequan", "icon_reduce", "uicon_reduce");
		$("#linkiconrq").click(function() {
			ControlPTZ(7, 0, 0);
		});
		MM_swapImgRestore("iconaddquan", "icon_add", "uicon_add");
		$("#linkiconaq").click(function() {
			ControlPTZ(6, 0, 0);
		});

		// 变倍
		MM_swapImgRestore("iconfocus", "icon_zoom", "uicon_zoom");
		MM_swapImgRestore("iconreducefocus", "icon_reduce", "uicon_reduce");
		$("#linkiconrz").click(function() {
			ControlPTZ(8, 0, 0);
		});
		MM_swapImgRestore("iconaddfocus", "icon_add", "uicon_add");
		$("#linkiconaz").click(function() {
			ControlPTZ(9, 0, 0);
		});

		// 步长
		MM_swapImgRestore("linkbtns", "btn_small_on", "ubtn_small_on");
		$("#linkbtns").click(function() {
			if (g_speed < 1) {
				$("#stepsatus").removeClass("step_status_none tupian");
			} else {
				$("#stepsatus").removeClass("step_status" + "_" + g_speed + " tupian");
			}
			g_speed--;
			if (g_speed < 1) {
				g_speed = 0;
				$("#stepsatus").addClass("step_status_none tupian");
			} else {
				$("#stepsatus").addClass("step_status" + "_" + g_speed + " tupian");
			}
		});
		MM_swapImgRestore("stepsatus","step_status_"+g_speed,"ustep_status_"+g_speed);
		MM_swapImgRestore("linkbtnl", "btn_large_on", "ubtn_large_on");
		$("#linkbtnl").click(function() {
			if (g_speed < 1) {
				$("#stepsatus").removeClass("step_status_none tupian");
			} else {
				if (g_speed > 5) {g_speed = 5;}
				$("#stepsatus").removeClass("step_status" + "_" + g_speed + " tupian");
			}
			g_speed++;
			if (g_speed > 5) {g_speed = 5;}
			$("#stepsatus").addClass("step_status" + "_" + g_speed + " tupian");
		});
		
		//控制语音通话
		MM_swapImgRestore("telopen","tel_open","utel_open");
		$("#linktelo").click(function(){
			StartTalk(0);
		});
		MM_swapImgRestore("telclose","tel_close","utel_close");
		$("#linktelc").click(function(){
			StopTalk(0);
		});
		
		//控制监听
		MM_swapImgRestore("boardopen","board_open","uboard_open");
		$("#linkboardo").click(function(){
			StartListen(0);
		});
		MM_swapImgRestore("boardclose","board_close","uboard_close");
		$("#linkboardc").click(function(){
			StopListen(0);
		});
		
		//控制录像
		MM_swapImgRestore("recopen","rec_open","urec_open");
		$("#linkreco").click(function(){
			StartRecord(0);
		});
		MM_swapImgRestore("recclose","rec_close","urec_close");
		$("#linkrecc").click(function(){
			StopRecord(0);
		});
		
		//抓拍
		MM_swapImgRestore("zpopen","zp_open","uzp_open");
		$("#zpopen").click(function(){
			SnapPic(0);
		});
		
	}
}

 
function AutoYuntai()
{
	if(g_AutoYuntai==0)
	{
		g_AutoYuntai = 1;
		ControlPTZ(27,10,10);
		ControlPTZ(28,10,10);
		ControlPTZ(29,10,10);
	}
	else
	{
		ControlPTZ(2,10,10);
		ControlPTZ(19,0,0);
		g_AutoYuntai = 0;
	}
}
function CamStatusCheck(info)
{
	
	var statusObj =JSON.parse(info);
	var devID = statusObj.devID;
	var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
	if(treeObj==null)
		return;
	switch(statusObj.reportType)
	{
	case 1://镜头选择
		g_cameraID = statusObj.cameraID;
		if(g_cameraID == 0 )
			SetControlPTZ(0);
		else
			SetControlPTZ(1);
		break;
	case 2://视频停止
		SetControlPTZ(0);
		break;
	case 3://设备上线
		var node  = treeObj.getNodeByParam("id", devID);
		 if(node.status==0){
			node.iconSkin = "encoder";
			node.status=1;
			treeObj.updateNode(node);
		}
		break;
	case 4://设备下线
		var node  = treeObj.getNodeByParam("id", devID);
		if(node.status==1){
			node.iconSkin = "encoderOffline";
			node.status=0;
			treeObj.updateNode(node);
		}
		break;
	}
	
}
function TreeStructAnalyze(info)
{
	var online = 0;
	var statusObj = eval("(" + info + ")");
	var NodeType = statusObj.NodeType;//0：工程；1:组；2：有线终端；
	var NodeName = statusObj.NodeName;
	var NodePID = statusObj.ParentNodeID;
	var nodeID = statusObj.NodeID;
	var nodeVer = statusObj.HardVer;
	var treeObj = $.fn.zTree.getZTreeObj("treeDemo");
	var parentNodes = null;
	var parentNode = null;
	var pNode;
	if(treeObj != null){
		parentNodes = treeObj.getNodesByParam("id", NodePID, null);
		parentNode = parentNodes[0];
	}
	if(NodeType == 1|| NodeType == 0){
		var newNode = {id : nodeID,pId : NodePID,name : NodeName,iconSkin : "home",nodeType:NodeType,toPlay:0};
		if(treeObj != null){
			treeObj.addNodes(parentNode,newNode,true);
		}
	}
	if(NodeType==2){
		online = statusObj.onLine;
		var icon = (online==1)?"encoder":"encoderOffline";
		var newNode = {id : nodeID,pId : NodePID,name : NodeName,iconSkin : icon,nodeType:NodeType,toPlay:0};
		if(treeObj != null){
			for (i=0;i<parentNodes.length;i++)
			{
				if(parentNodes[i].nodeType == 1)
					parentNode = parentNodes[i];
			}

			treeObj.addNodes(parentNode,newNode,true);
		}
	}
	if(NodeType==3){
		if(treeObj != null){
			if(parentNode.iconSkin == "encoder"){
				online = 1;
				$("#mydevice").append("<option value="+nodeID+">"+NodeName+"</option>");
			}
			var newNode = {id : nodeID,pId : NodePID,name : NodeName,iconSkin : "camera",nodeType:NodeType,toPlay:online};
			for (i=0;i<parentNodes.length;i++)
			{
				if(parentNodes[i].nodeType == 1)
					parentNode = parentNodes[i];
			}
			treeObj.addNodes(parentNode,newNode,true);
			
		}
	}
	
}
//全局变量
var g_AutoYuntai = 0;
var g_cameraID;
var g_speed = 1;
var g_enablePannel = 0;
var g_selectTreeNode;