
<?php
$no_visible_elements=true;
include('header.php');
?>


			<div class="row-fluid">
				<div class="span3"></div>
				<div class=" span5 ">
					<h2></h2>
				</div><!--/span-->
			</div><!--/row-->
			
			<div class="row-fluid">
				<div class="span3"></div>
				<div class="well span6  " style="margin-top:50px">
					<form  class="form-horizontal" id="forget-pwd-form" >
					 	<fieldset>
					 		<legend>获取密码</legend>					 		
					 		<div class="alert alert-info center" id="alert-message">
								请输入您注册的用户名和Email以获取密码
							</div>
						   	<div class="control-group">
						    	<label class="control-label" for="userName">用户名</label>
						    	<div class="controls">
						     		<input type="text" name="username" id="username" value="" placeholder="请输入您的用户名">
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
						    	  	<input type="submit" class="btn span4 btn-primary pull-left" value="获取密码">
						      		<a href=<?php echo base_url('login')?> class="btn span4">返回登陆</a>
								</div>
						    </div>
					    </fieldset>
					</form>
					
				</div><!--/span-->
			</div><!--/row-->
		





<?php include('footer.php'); ?>


<script type="text/javascript">

$(document).ready(function () {
	
	$("#forget-pwd-form").validate({
		rules: {
			username: {
				required: true
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			username: {
				required: "请输入用户名"
			},
			email: "请输入正确的email地址"
		},
		submitHandler: function(){  
			var params = {user_name:$("#username").val(),reg_email:$("#email").val()};
			$.ajax({
				type: 'POST',
				url: BASE_URL+'command/refind_password',
				dataType: 'json',
				data:params,
				success: function (data) {
					if (data.errorCode == "0d") {
						changeAlertMsg(data.errorDesc+",请检查您的邮箱","alert-success");
						//location.href = BASE_URL+"start/my_camera";				
					}
					else
					{
						changeAlertMsg(data.errorDesc,"alert-error");
					}
				},
				error: function () {
					changeAlertMsg("操作超时","alert-error");
				}
			});
			
		}
	});
});

	
</script>
