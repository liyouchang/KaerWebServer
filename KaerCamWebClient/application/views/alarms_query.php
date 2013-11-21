<?php include('header.php'); ?>

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">视频监控功能</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><?php echo $title?></a>
					</li>
				</ul>
			</div>

			<div class="row-fluid ">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-calendar"></i>查询条件</h2>
					  	<div class="box-icon">
						  <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
				  	</div>
					<div class="box-content">
					
						<form class="form-horizontal">
				      		<fieldset>
								<div class="control-group">
							 		<label class="control-label" for="startTime">开始时间</label>
							  		<div class="controls">
							    		<input type="text" class=" datetimepicker" id="startTime">
							  		</div>
								</div>
								<div class="control-group">
						  			<label class="control-label" for="endTime">结束时间</label>
						  			<div class="controls">
						    			<input type="text" class=" datetimepicker" id="endTime">
						  			</div>
								</div>
								<div class="control-group">
						  			<label class="control-label" for="alarmType">报警类型</label>
						  				<div class="controls">
										  <select id="alarmType">
											<option>全部</option>
											<option>移动侦测告警</option>
											<option>信号丢失告警</option>
											<option>遮挡告警</option>
										  </select>
										</div>
						 		</div>
							
							 	<div class="form-actions">
						  			<button type="button" class="btn btn-info">查询</button>
								</div>
					      	</fieldset>
					   	</form>	
					
					</div>
				</div><!-- span -->
			</div><!--/row-->
		
			<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2>查询结果</h2>
						<div class="box-icon">	
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
									  <th>报警器名称</th>
									  <th>视频服务器名称</th>
									  <th>报警类型</th>
									  <th>报警时间</th>   
									  <th>备注</th>    
									  <th>操作</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
								<tr>
									<td>Kaer</td>
									<td>Kaer</td>
									<td>移动侦测</td>
									<td class="center">2012/01/01</td>
									<td class="center">Member</td>
									<td class="center">
										<span class="label label-success">Active</span>
									</td>                                       
								</tr>
							                               
							  </tbody>
						 </table>  
					</div>
				</div><!--/span-->
			</div><!--/row-->
<?php include('footer.php'); ?>
