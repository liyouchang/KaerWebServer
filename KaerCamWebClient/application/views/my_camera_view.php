<?php include('header.php'); ?>

<script type="text/javascript">



		
//camera control pannel functions

function MM_swapImgRestore(id,cs1,cs2)
{
	if($("#"+id).hasClass(cs2))
	{
		$("#"+id).removeClass(cs2);
	}
	if(!$("#"+id).hasClass(cs1))
	{
		$("#"+id).addClass(cs1);
	}
}
function MM_swapImage(id,cs1,cs2)
{
	if($("#"+id).hasClass(cs1))
	{
		$("#"+id).removeClass(cs1);
	}
	if(!$("#"+id).hasClass(cs2))
	{
		$("#"+id).addClass(cs2);
	}
}
//控制带云台操作的播放窗口的展示
function advancedOption()
{
	if($("#advancedoption").css("display")=="none")
	{
		$("#advancedoption").css("display","block");
		//$("#controlAdvancedIcon").css("class","active icon icon-color icon-arrowstop-n");
		$("#hidemore").text('收起更多操作');
	}
	else
	{		
		$("#advancedoption").css("display","none");
		//$("#controlAdvancedIcon").css("class","active icon icon-color icon-arrowstop-s");
		$("#hidemore").text('展开更多操作');
	}
}

function ViewTree(bView)
{
	var player = document.getElementById("player");
	
	if($("#viewTree").text()=="显示树形列表")
	{
		
		$("#viewTree").text("隐藏树形列表");
		player.IsViewTree(1);
	}else
	{
		$("#viewTree").text("显示树形列表");
		player.IsViewTree(0);
	} 
}

function setDivMode(value)
{
	var player = document.getElementById("player");
	player.Splitscreen(value);
	return false;
}

//成功登录标记
var login=false;
//是否安装插件
var hasplug=true;
//登录播放插件
function loginplug()
{
	var player = document.getElementById("player");
	//player.WebClose();
	var IVS_IP = "192.168.2.247",IVS_User = $.cookie('UserName'),IVS_Psw = $.cookie('Password');
 	var lRet = 0;
	player.WebLogin(IVS_User,IVS_Psw,IVS_IP,lRet);
	lRet=player.IsLogin;
  	if(lRet==0){
  	  login=true;
  	  $("#infoText").text("登录成功");
  	} else{
  		login=false;
  	 	$("#infoText").text("登陆失败,errorCode="+lRet);
  	}
}

$(document).ready(function(){
	if(initObject1())
	{
		//loginplug();
	}
	else
	{// 未安装插件提示
		hasplug=false;
		$("#infoText").text("监控插件未安装！");
	}

	$('#videoPannelClick').trigger("click");
	
	advancedOption();
	$('.hidePlayer').click(function(){$('#player').hide();});
	$('.showPlayer').click(function(){$('#player').show();});
	$('#doShareCam').click(function(){
		//alert("test");
		//var options = $.parseJSON('');
		noty({"text":"分享失败","layout":"bottomLeft","type":"error"});
		$('#player').show();
		$('#shareCam').modal('hide');
		
	});
	
	$('#doDeleteCam').click(function(){
		//执行删除		
		noty({"text":"删除成功","layout":"bottomLeft","type":"success"});
		$('#player').show();
		$('#deleteCam').modal('hide');
		 var anSelected = fnGetSelected( oTable );
	     if ( anSelected.length !== 0 ) {
	         oTable.fnDeleteRow( anSelected[0] );
	     }
	});
	
	$('#doAddCam').click(function(){
		noty({"text":"添加成功","layout":"bottomLeft","type":"success"});
		$('#player').show();
		$('#addCam').modal('hide');
		var action = '<a class="btn btn-primary" onclick="fnClickAddRow()">播放</a> '+
		'<a href="#shareCam" role="button" class="btn btn-success hidePlayer" data-toggle="modal">分享</a> '+
		'<a href="#cancelShareCam" data-toggle="modal"class="btn btn-warning hidePlayer">取消分享</a> '+
		'<a href="#renameCam" data-toggle="modal" class="btn btn-warning hidePlayer">重命名</a> '+
		'<a href="#deleteCam" data-toggle="modal" class="btn btn-danger"  >删除</a> ';
		oTable.fnAddData( [
       	 	giCount+".1",
        	giCount+".2",
        	action] );
		 giCount++;

		 
		$("#camList tbody tr").click( function( e ) {
            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
    	});
	});
	
	$("#camList tbody tr").click( function( e ) {
            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
    });
	oTable = $('#camList').dataTable();

	$(".playVedio").click(function(){
		var player = document.getElementById("player");
		
		var out = player.QueryUserCamera();
		alert(out);
		var options = $.parseJSON(out);
		alert(options.array[0].php);
	});
});

/* Get the rows which are currently selected */
function fnGetSelected( oTableLocal )
{
    return oTableLocal.$('tr.row_selected');
}

function DetectActiveX()
{
	   try
	   {
	      var comActiveX = new ActiveXObject("Ke2008WebProj1.Ke2008Web");   
	   }
	   catch(e)
	   {
		      return false;
	   }
	    return true;
}

//退出时先注销插件
function logout()
{
	if(!hasplug )
	{
		//document.URL = "/cwmp/logout.jsp";
	}else
	{
		if(login==true)
		{
		    var player = document.getElementById("player");
		    player.LogOut();
		   
		}else
		{
			$("#infoText").text("插件正在登录，请稍后再试 ");
		}
	}
}

// 关闭页面时，调登出接口
$(window).unload( function () {logout(); } );

var giCount=0;

function fnClickAddRow() {
	
     
    giCount++;
    //ToDo: find another way to bind dynamic add object
	$("#camList tbody tr").click( function( e ) {
        oTable.$('tr.row_selected').removeClass('row_selected');
        $(this).addClass('row_selected');
	});
}

</script>

<style type="text/css">

</style>

			<div class="row-fluid span8">	
				<div class="box ">
					<div class="box-header well" data-original-title>
						<h2>视频窗口</h2>
						<div class="box-icon">
							<a href="#" id="videoPannelClick" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> 
						</div>
					</div>
					
					<div class="box-content ">
						 
							<!--插件、及云台信息开始-->
							<!-- 插件定义开始 -->
							<div id="movie1" class="center" style="WIDTH: 730px; HEIGHT: 400px;"></div> 
							<!-- 插件定义结束 -->		
												
							<div id="" class=" box " >
								<!-- 控制更多操作开始 -->
								<div class="controlH clearfix">
									<a class="btn btn-small" id="hidemore" onClick="javascript:advancedOption()">
									<!-- <span class="active icon icon-color icon-arrowstop-n" id="controlAdvancedIcon"></span> --> 
									 收起更多操作</a>
									
									 <div class="screen" id="screen">
										<span class="screen1" onClick="javascript:setDivMode(1)" ></span>
										<span class="screen4" onClick="javascript:setDivMode(4)" ></span>
										<!-- 
										<span class="screen6" onClick="javascript:setDivMode(6)" ></span>
										<span class="screen8" onClick="javascript:setDivMode(9)" ></span>
										 -->
									</div>
									<span class="pull-right " style="margin-right:5px">
										
									<i class="icon-exclamation-sign "></i><span id="infoText" class="label label-info">
									操作成功</span>
									</span>
									<!-- 表格提示  -->
								</div>
								<!-- 控制更多操作结束 -->
								<!--云台区域信息开始  -->
								<div  class="pannel " id="advancedoption" >
									<!--云镜信息展示开始  -->
									<div class="pControl1">
										<a href="#PP" id="linkDir02"				
											onMouseOut=MM_swapImgRestore('direction02','direction_02','direction_on_02'); 
											onMouseOver=MM_swapImage('direction02','direction_02','direction_on_02');>
											<span title='上' id='direction02' class="direction_02" ></span>
										</a>
										<a href="#PP" id="linkDir04"					
											onMouseOut=MM_swapImgRestore('direction04','direction_04','direction_on_04'); 
											onMouseOver=MM_swapImage('direction04','direction_04','direction_on_04'); >
											<span  title='左' id='direction04' class="direction_04"></span>
										</a>
										<a href="#PP" id="linkDir05"					
											onMouseOut=MM_swapImgRestore('direction05','direction_05','direction_on_05'); 
											onMouseOver=MM_swapImage('direction05','direction_05','direction_on_05');>
											<span  title='锁定' id='direction05' class="direction_05"></span>
										</a>
										<a href="#PP" id="linkDir06"					
											onMouseOut=MM_swapImgRestore('direction06','direction_06','direction_on_06'); 
											onMouseOver=MM_swapImage('direction06','direction_06','direction_on_06');>
											<span  title='右' id='direction06' class="direction_06"></span>
										</a>
										<a href="#PP" id="linkDir08"					
											onMouseOut=MM_swapImgRestore('direction08','direction_08','direction_on_08'); 
											onMouseOver=MM_swapImage('direction08','direction_08','direction_on_08');>
											<span  title='下' id='direction08' class="direction_08"></span>
										</a>
									</div>
									<!--云镜信息展示结束  -->
							
									<!--焦距、步长控制开始  -->
									<div class="pControl2">
										<div class="pControl2-g1 clearfix">
											<span class="ptext label">光圈</span>
											<span title='自动' id='iconforcus' class="iconLay icon_forcus"></span>
											<a href="#PP" id="linkiconr" class="iconLay "> 
												<span title='减小' id='iconreduce' class="icon_reduce"></span>
											</a>
											<a href="#PP" id="linkicona" class="iconLay">
												<span title='增大' id='iconadd' class="icon_add"></span>
											</a>
										</div>
										<div class="pControl2-g2 clearfix">
											<span class="ptext label">焦距</span>
											<span title='自动' id='iconquan' class="iconLay icon_quan"></span>
											<a href="#PP" id="linkiconrq" class="iconLay">
												<span title='拉近' id='iconreducequan' class="icon_reduce"></span>
											</a>
											<a href="#PP" id="linkiconaq" class="iconLay">
												<span title='拉远' id='iconaddquan' class="icon_add"></span>
											</a>
										</div>
										<div class="pControl2-g3 clearfix">
											<span class="ptext label">聚焦</span>
											<span title='自动' id='iconfocus' class="iconLay icon_zoom"></span>
											<a href="#PP" id="linkiconrz" class="iconLay">
												<span title='减小' id='iconreducefocus' class="icon_reduce" ></span>
											</a>
											<a href="#PP" id="linkiconaz" class="iconLay">
												<span title='增大' id='iconaddfocus' class="icon_add" ></span>
											</a>
										</div>
										<div class="pControl2-g4 clearfix">
											<span class="ptext label">步长</span>
											<a href="#PP" id="linkbtns" title='减小步长' class="iconLay btn_small_on"></a>
											<span id="ptzstep" align="center" class="iconLay">
												<span id='stepsatus' title='步长' class="step_status_1"></span>
											</span>
											<a href="#PP" id="linkbtnl" title='增加步长' class="iconLay btn_large_on"></a>
										</div>
									</div>
									<!--焦距、步长控制结束  -->
							
									<!--语音、通信控制开始  -->
									<div class="pControl3">
										<div class="pControl3-g1 clearfix">
											<span class="ptext label">广播</span>
											<a href="#PP" id="linkboardo" class="iconLay"> 
												<span title='广播' id='boardopen' class="board_open"></span>
											</a>
											<a href="#PP" id="linkboardc" class="iconLay">
												<span title='停止广播' id='boardclose' class="board_close"></span>
											</a>
										</div>
										<div class="pControl3-g2 clearfix">
											<span class="ptext label">通讯</span>
											<a href="#PP" id="linktelo" class="iconLay">
												<span title='开始通话' id='telopen' class="tel_open"></span>
											</a>
											<a href="#PP" id="linktelc" class="iconLay">
												<span title='停止通话' id='telclose' class="tel_close"></span>
											</a>
										</div>
										<div class="pControl3-g3 clearfix">
											<span class="ptext label">录像</span>
											<a href="#PP" id="linkreco" class="iconLay">
												<span title='开始录像' id='recopen' class="rec_open"></span>
											</a>
											<a href="#PP" id="linkrecc" class="iconLay">
												<span title='停止录像' id='recclose' class="rec_close"></span>
											</a>
										</div>
										<div class="pControl3-g4 clearfix">
											<span class="ptext label">抓拍</span>
											<a href="#PP" id="linkzpo" onClick="cmdCapPicEx()" class="iconLay">
												<span class='zp_open' title='抓拍' id='zpopen'></span>
											</a>			
										</div>
									</div>
									<!--语音、通信控制结束  -->
								</div>
							  <!--云台区域信息结束 -->
							</div>
							<!--插件、及云台信息结束-->
					
					</div>
				</div><!--/span-->	
				
			</div><!--/row-->
			
		<div class="row-fluid span8">	
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2>我的摄像机</h2>
						
						<!-- 
						<div class="box-icon">	
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
						 -->
					</div>
					
					<div class="box-content">
					
						<a href="#addCam" data-toggle="modal" class="btn btn-info hidePlayer">添加摄像机</a>

						<h5>我的摄像机列表:</h5>
						<table id="camList" class="table table-bordered table-striped table-condensed bootstrap-datatable datatable">
							  <thead>
								  <tr>
									  <th>镜头名称</th>
									  <th>状态</th>
									  <th style="width: 500px">操作</th>
								
								  </tr>
							  </thead>   
							  <tbody>
								<tr>
									<td >Kaer</td>
									<td><span class="label label-success">在线</span></td>
									<td >
										<a class="btn btn-primary playVedio" >播放</a>
										<a href="#shareCam" role="button" class="btn btn-success hidePlayer" data-toggle="modal">分享</a>
										<a href="#cancelShareCam" data-toggle="modal"class="btn btn-warning hidePlayer">取消分享</a>
										<a href="#renameCam" data-toggle="modal" class="btn btn-warning hidePlayer">重命名</a>
										<a id="deleteRow" class="btn btn-danger hidePlayer" >删除</a>
									</td>	                               
								</tr>
							 
								                 
							  </tbody>
						 </table>  
					</div>
				</div><!--/span-->
			</div><!--/row-->	

		<!-- Modal -->
		<!-- 分享功能  -->
			<div id="shareCam" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="shareCamLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close showPlayer" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="shareCamLabel">分享我的摄像机</h3>
			  </div>
			  <form  class="form-horizontal"  id="shareCamForm" >
			  <div class="modal-body">
			  	
					<div class="control-group">
					    <label class="control-label" for="username">接受者名字</label>
					    <div class="controls">
					      <input type="text" name="username" id="username" value="" placeholder="">
					    </div>
					</div>
			  </div>
			  <div class="modal-footer">			  
			   	<button type="submit" class="btn btn-primary " id="doShareCam">分享</button>
			    <button class="btn btn-inverse showPlayer" data-dismiss="modal" aria-hidden="true">取消</button>
			  </div>
			  </form>
			</div>
			<!-- 添加功能  -->
			<div id="addCam" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="addCamLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close showPlayer" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="addCamLabel">添加我的摄像机</h3>
			  </div>
			  <form  class="form-horizontal"  id="addCamForm" >
			  	<div class="modal-body">
			  		<div class="alert alert-block"><p> 摄像机在线时才能添加</p></div>
					<div class="control-group">
					    <label class="control-label" for="camID">摄像机ID</label>
					    <div class="controls">
					      <input type="text" name="camID" id="camID" value="" placeholder="">
					    </div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="camName">摄像机名称</label>
					    <div class="controls">
					      <input type="text" name="camName" id="camName" value="" placeholder=""> 
					    </div>
					</div>
			  	</div>
			  	<div class="modal-footer">			  
			   		<button type="submit" class="btn btn-primary " id="doAddCam">添加</button>
			    	<button class="btn btn-inverse showPlayer" data-dismiss="modal" aria-hidden="true">取消</button>			    
			  	</div>
			 	</form>
			</div>
			<!-- 重命名功能  -->
			<div id="renameCam" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="renameCamLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close showPlayer" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="renameCamLabel">重命名我的摄像机</h3>
			  </div>
			  <form  class="form-horizontal" action="#" id="renameCamForm" >
			  	<div class="modal-body">
					<div class="control-group">
					    <label class="control-label" for="camName">新的摄像机名称</label>
					    <div class="controls">
					      <input type="text" name="camName" id="camName" value="" placeholder=""> 
					    </div>
					</div>
			  	</div>
			  	<div class="modal-footer">			  
			   		<button type="submit" class="btn btn-primary " id="doRenameCam">重命名</button>
			    	<button class="btn btn-inverse showPlayer" data-dismiss="modal" aria-hidden="true">取消</button>			    
			  	</div>
			 	</form>
			</div>
			<!-- 取消分享 -->
			<div id="cancelShareCam" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="cancelShareCamLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close showPlayer" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="cancelShareCam">删除分享摄像机</h3>
			  </div>
			  <form  class="form-horizontal" action="#" id="cancelShareCamForm" >
			  	<div class="modal-body">
					<div class="control-group">
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户1   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户2   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户3   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户4   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户5   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户6   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户7   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户8   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户9   </label>
						<label class="checkbox"><input type="checkbox" class="" id=""/> 用户10   </label>
					</div>
			  	</div>
			  	<div class="modal-footer">			  
			   		<button type="submit" class="btn btn-primary " id="doCancelShareCam">删除</button>
			    	<button class="btn btn-inverse showPlayer" data-dismiss="modal" aria-hidden="true">取消</button>			    
			  	</div>
			 	</form>
			</div>
			<!-- 删除摄像机 -->
			<div id="deleteCam" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteCamLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close showPlayer" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="deleteCamLabel">删除我的摄像机</h3>
			  </div>
			  	<div class="modal-body">
			  		<div class="alert alert-block alert-error fade in"><p> 你确定删除吗?</p></div>
			  	</div>
			  	<div class="modal-footer">			  
			   		<button class="btn btn-danger " id="doDeleteCam">确定</button>
			    	<button class="btn btn-inverse showPlayer" data-dismiss="modal" aria-hidden="true">取消</button>			    
			  	</div>
			</div>
    
<?php include('footer.php'); ?>
