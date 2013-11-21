
<?php
$no_visible_elements=true;
include('header.php');
?>


			<div class="row-fluid">
				<div class="span3"></div>
				<div class=" span5 ">
					<h2>用户注册</h2>
				</div><!--/span-->
			</div><!--/row-->
				<div class="row-fluid">
				<div class="span3"></div>
				<div class="well span6  ">
					<!-- <form class="form-inline " id="login-form" action="#" method="post"> -->
					<form  class="form-horizontal" id="register-form" >
					
					   <div class="control-group">
					   <label class="control-label" for="myUserName">用户名</label>
					   <div class="controls">
					   	<input type="text" name="myUserName" id="myUserName" value="" placeholder="使用数字、字母及下划线">
					   </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label" for="myPassword">密码</label>
					    <div class="controls">
					      <input type="password" name="myPassword" id="myPassword" value="" placeholder="请输入用户密码"> 
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <label class="control-label" for="confirm_password">确认密码</label>
					    <div class="controls">
					      <input type="password" name="confirm_password" id="confirm_password" placeholder="请确认密码">
					    </div>
					  </div>
					   <div class="control-group">
					    <label class="control-label" for="email">Email</label>
					    <div class="controls">
					      <input type="text" id="email" name="email" placeholder="请输入您的邮箱">
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <div class="controls">
					      <label id="agree"  class="checkbox"><input name="agree" type="checkbox"> 
					      	我同意<a href="<?php  echo base_url("plugin/agreement.html")?>">用户协议</a></label>
					   	</div>
					   </div>
					    
					   <div class="control-group" id="xcode_group" style="display:none">
					    <label class="control-label" for="xcode">验证码</label>
					    <div class="controls">
					      <input type="text" id="xcode" name="xcode" placeholder="请输入您收到的验证码,验证码10分钟内有效">
					    </div>
					  </div> 
					  
					    <div class="control-group">
					    <div class="controls">
					    	<input id="register_btn" type="submit" class="btn  btn-primary span4 pull-left" value="注册">
					      	<a href=<?php echo base_url('login')?> class="btn span4">返回登陆</a>
						</div>
					    </div>
					
					</form>
					
				</div><!--/span-->
			</div><!--/row-->
		





<?php include('footer.php'); ?>

<script type="text/javascript">

$(document).ready(function () {
	$("#register-form").validate({
		rules: {
			myUserName: {
				required: true,
				maxlength: 20,
				minlength:3
			},
			myPassword: {
				required: true,
				maxlength: 20,
				minlength:6
			},
			confirm_password: {
				required: true,
				equalTo: "#myPassword"
			},
			email: {
				required: true,
				email: true
			},
			xcode: "required",
			agree: "required"
		},
		messages: {
			myUserName: {
				required: "请输入用户名",
				maxlength:"用户名最大长度为20",
				minlength:"用户名最短长度为3"
			},
			myPassword: {
				required: "请输入密码",
				maxlength:"密码最大长度为20",
				minlength:"密码最短长度为6"
			},
			confirm_password: {
				required: "请输入确认密码",
				equalTo: "确认密码与密码需一致"
			},
			email: "请输入正确的email地址",
			agree: "需要同意用户协议",
			xcode:"需要输入验证码"
		},
		submitHandler: function(){  
			var params = {user_name:$("#myUserName").val() ,user_pwd:$("#myPassword").val(),
					reg_email:$("#email").val(),reg_code:$("#xcode").val()};
			//alert(JSON.stringify(params));
			$.ajax({
				type: 'POST',
				url: BASE_URL+'command/user_register',
				dataType: 'json',
				data:params,
				success: function (data) {
					if (data.errorCode == "0d") {
						alert(data.errorDesc);
						location.href = BASE_URL+"start/monitoring";				
					}else if(data.errorCode=='08')
					{
						AlertMessage("验证码已经发到您的注册邮箱，在十分钟内有效");
						$("#register_btn").val("注册");
						$("#xcode_group").css('display','block');
					}
					else
					{
						AlertMessage(data.errorDesc,'error');
					}
				},
				error: function () {
					AlertMessage("失败....",'error');
				}
			});

		}
		
	});
});

	
</script>

