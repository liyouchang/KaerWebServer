<?php include('header.php'); ?>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">其他功能</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">系统配置</a>
					</li>
				</ul>
			</div>
				<div id="movie1" class="center" style="display:none"></div> 
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> 系统参数配置</h2>
						
					</div>
					<div class="box-content">
						<form class="form-horizontal">
						  <fieldset>
							<legend>本地保存路径</legend>
							<div class="control-group">
							  <label class="control-label " for="snapPath">抓拍图片保存路径</label>
							  <div class="controls ">
								<input type="text" class="input-large" id="snapPath" >
								<button class="btn" type="button" onclick="SetSnapPath(this)">设置</button>
							  </div>
							</div>       
							<div class="control-group">
							  <label class="control-label" for="videoPath">录像文件保存路径</label>
							  <div class="controls">
								<input type='text' class="input-large" id="videoPath" >
								<button class="btn" type="button" onclick="SetVideoPath(this)">设置</button>
							  </div>
							</div>
							
						  </fieldset>
						</form>   
						<form id="form-pwdChange" class="form-horizontal" >
							<fieldset>
								<legend>用户密码修改</legend>
								
								<div class="control-group">
							 	 	<label class="control-label " for="oldPassword" >旧密码</label>
							  		<div class="controls">
										<input type="password" class="input-large" name="oldPassword" id="oldPassword" value="" required>
							  		</div>
								</div>
								<div class="control-group">
							 	 	<label class="control-label " for="newPassword" >新密码</label>
							  		<div class="controls">
										<input type="password" class="input-large" name="newPassword" id="newPassword" value="" required>
							  		</div>
								</div>
								<div class="control-group">
							 	 	<label class="control-label " for="againPassword" >密码重复</label>
							  		<div class="controls"> 
										<input type="password" class="input-large" name="againPassword" id="againPassword" value="" required>
							  		</div>
								</div>
								<div class="control-group">
									<div class="controls"> 
										<button type="submit" class="btn btn-info">修改密码</button>
							  		</div>
							  		
								</div>
							</fieldset>
						</form>
					</div>
				</div><!--/span-->
			</div><!--/row-->

    
<?php include('footer.php'); ?>

<script type="text/javascript">
<!--

$(function () {
	$("#menu-sysParam").addClass("active");
	$("#form-pwdChange").validate({
		rules: {
			oldPassword: {required: true,maxlength: 20,minlength:6},
			newPassword: {required: true,maxlength: 20,minlength:6},
			againPassword: {required: true,equalTo: "#newPassword"}
		},
		messages: {
			oldPassword: {required: "请输入原密码",maxlength:"密码最大长度为20",minlength:"密码最短长度为6"},
			newPassword: {required: "请输入新密码",maxlength:"密码最大长度为20",minlength:"密码最短长度为6"},
			againPassword: {required: "请输入确认密码",equalTo: "确认密码与新密码需一致"}
		},
		submitHandler: function(){  
			var params = {oldPwd:$("#oldPassword").val() ,newPwd:$("#newPassword").val()};
			$.ajax({
				type: 'POST',
				url: BASE_URL+'command/change_user_pwd',
				dataType: 'json',data:params,
				success: function (data) {
					if (data.errorCode == "0d") {AlertMessage("修改用户密成功","success");}
					else { AlertMessage("修改用户密失败-" + data.errorDesc,"error");}
				},
				error: function () {AlertMessage("修改用户密码"+"操作失败","error");}
			});
		}
	});
	var player = document.getElementById("player");
	if(player == null)
	{
		//AlertMessage("播放插件未安装","info");
	}
	else
	{
		$("#snapPath").val(player.SnapFilePath);
		$("#videoPath").val(player.RecordFilePath);
	}


	$("#snapPath,#videoPath").click(function(){
		var path = player.GetLocalPath();
		if(path.length != 0)
			$(this).val(path);
		});
});

function SetSnapPath(element)
{	
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","info");
	}
	else
	{
		player.SnapFilePath = $(element).parent().children('#snapPath').val();
	}
}
function SetVideoPath(element)
{
	var player = document.getElementById("player");
	if(player == null)
	{
		AlertMessage("播放插件未安装","info");
	}
	else
	{
		player.RecordFilePath = $(element).parent().children('#videoPath').val();
	}
}
//-->
</script>

