<?php
$no_visible_elements=true;
include('header.php'); 
?>

			<div class="row">
				<div class="span12 center login-header">
					<h2>欢迎使用视频监控系统</h2>
				</div><!--/span-->
			</div><!--/row-->
			
			<div class="row">
				<div class="span3"></div>
				<div class="span6 login-box">
					<div class="alert alert-info center" id="alert-message">
						请使用您的用户名和密码登录.
					</div>
					
					<form class="form-inline center" id="login-form" action="#" method="post">
						<fieldset>
							<div class="control-group"> 
								<div class="input-prepend controls " title="用户名" data-rel="tooltip">
									<span class="add-on"><i class="icon-user"></i></span>
									<input autofocus class="input-large span10" name="username" id="username" type="text"  />
								</div>
							</div>
							<div class="control-group ">
								<div class="controls input-prepend"  title="密码" data-rel="tooltip">
									<span class="add-on"><i class="icon-lock"></i></span>
									<input class="input-large span10" name="password" id="password" type="password"  />
								</div>
							</div>
						
							<div class="control-group">								
								<label class="checkbox remember add-on"><input type="checkbox" class="" id="remember-long" onclick=SetCheck() /> 记住密码   </label>
								<a href="<?php echo base_url('login/forget_pwd')?>" class="forgetPwd" style="disabled:true"> 忘记密码? </a> 
							</div>
							<div class = "control-group">
								<input type="submit" class="btn btn-primary btn-login center" value="登录"/>
							</div> 	 
						</fieldset>
					</form>
					
					<div class="login_Panel_bottom center">
                   	 	<a id="hreDownLoad" href ="<?php echo $pluginFilePath?>"  class="pull-left" style="display:block;">插件下载</a>
                   	 	<a id="signup" href ="<?php echo $pluginFilePath?>"  class="pull-right" style="display:block;"></a>
                   	 	<a id="signup" href ="<?php  echo base_url("login/register")?>"  class="pull-right" style="display:block;">用户注册</a>
                   	 	
                	</div>
				</div><!--/span-->
			</div><!--/row-->
		
		
<?php include('footer.php'); ?>


<script type="text/javascript">
<!--

$(function () {
	$("#login-form").validate({
		rules: {
			username: {
				required: true,
				maxlength: 20,
				minlength:3
			},
			password: {
				required: true,
				maxlength: 20,
				minlength:6
			}
		},
		messages: {
			username: {
				required: "请输入用户名",
				maxlength:"用户名最大长度为20",
				minlength:"请至少输入3位用户名"
			},
			password: {
				required: "请输入密码",
				maxlength:"密码最大长度为20",
				minlength:"请至少输入6位密码"
			}
		},
		submitHandler: function() {  
			var uname = $("#username").val(), //用户名
			pwd = $("#password").val();//用户密码
			$("#login-form input").attr('disabled', true);
			$('.remember').unbind('click');

			//已经向服务器提交了信息，所以将页面上的所有输入框按钮设置成不可用状态，这样可以有效的避免重复提交
			changeAlertMsg("正在登陆……","alert-info");
			ajaxCheckLogin(uname, pwd);
		},
		errorPlacement:function(label, element){
			$(element).popover('destroy');
			$(element).popover({"content":label.html(),"trigger":"manual"});
			$(element).popover('show');
		},
		success:function(label, element){
			$(element).popover('destroy');
		}
	});

	var ajaxCheckLogin = function (uname, pwd, remb) {
		$(".btn-master").addClass("visibility");
		//var params = "user_name=" + decodeURI(uname) + "&user_pwd=" + decodeURI(pwd) ;
		var params = {user_name:decodeURI(uname) ,user_pwd:decodeURI(pwd)};
		
		$.ajax({
			type: 'POST',
			url: BASE_URL+'command/login_confirm',
			dataType: 'json',
			data:params,
			success: function (data) {
				if (data.errorCode == "0d") {
					$.cookie('clientID', data.clientID, { expires: 7, path: '/' });
					if ($('#remember-long').attr('checked')) { //记住密码
						$.cookie('UserName', uname, { expires: 7, path: '/' });
						$.cookie('Password', pwd, { expires: 7, path: '/' });
					}
					else {//取消记住的密码，或者没有记住密码
						$.cookie('UserName', null,{ expires: 7, path: '/' });
						$.cookie('Password', null,{ expires: 7, path: '/' });
					}
					changeAlertMsg(data.errorDesc,"alert-success");
					location.href = BASE_URL+"start/monitoring";				
				}else {
					changeAlertMsg(data.errorDesc,"alert-error");
					$("#login-form input").attr('disabled', false);
				}
			},
			error: function () {
				changeAlertMsg("超时，请重新登陆","alert-error");
				$("#login-form input").attr('disabled', false);
				$('.remember').bind('click', function () { checkClick(); });
				$(".btn-master").removeClass("visibility");
			}
		});
	};

	rememberPassword();
	
	$(document).bind('keydown', 'return', function () { $(".btn-login").trigger('click'); });
	
});


function rememberPassword() {//页面加载完成之后执行自动登录检查
	var ckname = $.cookie('UserName');
	var ckpwd = $.cookie("Password");
	var logout = $.cookie("logout");//判断用户是否是从内部退出
	
	if (ckname != "" && ckpwd != "" && ckname != null && ckpwd != null) {
		$('#remember-long').attr('checked', true);
		$("#username").val(ckname); //用户名
		$("#password").val(ckpwd); //用户密码
	}
	else {
		$('#remember-long').attr('checked', false);
	}
}

function SetCheck()
{
	if( $('#remember-long').attr('checked'))
	{
		$('#remember-long').attr('checked', false);
	}
	else
	{
		$('#remember-long').attr('checked', true);
	}
}
//-->
</script>