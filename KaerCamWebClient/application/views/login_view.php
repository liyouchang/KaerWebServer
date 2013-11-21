<?php
$no_visible_elements=true;
include('header.php'); 
?>

		<div class="login-box">
					<?php if($centerSvrType == 1):?>
					<form class="form-horizontal login-form" id="login-form" action="#" method="post">
					<?php else:?>
					<form class="form-horizontal login-form" id="login-form08" action="#" method="post">
					<?php endif;?>
						<fieldset>
							<div class="control-group"> 
								<label class="control-label" for="myUserName">用户名</label>
								<div class=" controls " title="用户名" data-rel="tooltip">
									<input autofocus class="input-large" name="username" id="username" type="text"  />
								</div>
							</div>
							<div class="control-group ">
								<label class="control-label" for="myPassword">密&nbsp;&nbsp;&nbsp;码</label>
								<div class="controls"  title="密码" data-rel="tooltip">
									<input class="input-large" name="password" id="password" type="password"  />
								</div>
							</div>
							<div class="control-group">	
							    <div class="controls">
								<label class="checkbox  inline pull-left"><input type="checkbox" class="" id="remember-long" onclick=SetCheck() /> 
									记住密码 </label>
								</div> 
							</div>
							<div class = "control-group">
							 	<div class="controls">
									<input type="submit" class="btn btn-primary btn-login" value="登录"/>
								</div>
								
							</div> 	
							<div class = "control-group">
								<div class="controls">
									<a  href ="<?php echo $pluginFilePath?>" >PC插件下载</a>
								</div>
								<div class="controls" style="margin-left:280px;">
								<!-- <a href="<?php echo base_url('login/forget_pwd')?>" >帮助</a> -->
								</div>
							</div> 	 
							
						</fieldset>
					</form>
					
					
		</div><!--/login-box-->
		
		
		
<?php include('footer.php'); ?>


<script type="text/javascript">
<!--
function s4() {
	  return Math.floor((1 + Math.random()) * 0x10000)
	             .toString(16)
	             .substring(1);
	};

	function guid() {
	  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
	         s4() + '-' + s4() + s4() + s4();
	}
	function guid20() {
		  return s4() + s4() + s4() + s4() + s4();
		}
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
			AlertMessage("正在登陆……","info");
			ajaxCheckLogin(uname, pwd);
		}
	});
	$("#login-form08").validate({
		rules: {
			username: {
				required: true,
				maxlength: 20,
				minlength:3
			},
			password: {
				required: true,
				maxlength: 20,
				minlength:1
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
				minlength:"请至少输入1位密码"
			}
		},
		submitHandler: function() {  
			var uname = $("#username").val(), //用户名
			pwd = $("#password").val();//用户密码
			$("#login-form input").attr('disabled', true);
			$('.remember').unbind('click');
			//已经向服务器提交了信息，所以将页面上的所有输入框按钮设置成不可用状态，这样可以有效的避免重复提交
			AlertMessage("正在登陆……","info");
			ajaxCheckLogin(uname, pwd);
		}
	});
	var ajaxCheckLogin = function (uname, pwd, remb) {
		$(".btn-master").addClass("visibility");
		var uuid = $.cookie('uuid');
		if(uuid == null)
		{
			uuid = guid20();
			$.cookie('uuid',uuid, { expires: 7, path: '/' });
		}
		//var params = "user_name=" + decodeURI(uname) + "&user_pwd=" + decodeURI(pwd) ;
		var params = {user_name:decodeURI(uname) ,user_pwd:decodeURI(pwd),user_mac:uuid};
		
		$.ajax({
			type: 'POST',
			url: BASE_URL+'command/login_confirm',
			dataType: 'json',
			data:params,
			success: function (data) {
				if (data.errorCode == "0d") {
					$.cookie('clientID', data.clientID, { expires: 7, path: '/' });
					$.cookie('LoginName', uname, { expires: 7, path: '/' });
					$.cookie('LoginPwd', pwd, { expires: 7, path: '/' });
					if ($('#remember-long').attr('checked')) { //记住密码
						$.cookie('UserName', uname, { expires: 7, path: '/' });
						$.cookie('Password', pwd, { expires: 7, path: '/' });
					}
					else {//取消记住的密码，或者没有记住密码
						$.cookie('UserName', null,{ expires: 7, path: '/' });
						$.cookie('Password', null,{ expires: 7, path: '/' });
					}
					AlertMessage(data.errorDesc,"success");
					location.href = BASE_URL+"start/monitoring";				
				}else {
					AlertMessage(data.errorDesc,"error");
					$("#login-form input").attr('disabled', false);
				}
			},
			error: function () {
				AlertMessage("超时，请重新登陆","error");
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