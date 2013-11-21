		<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
			</div><!-- content-inner ends -->
		</div><!--/#content end-->
		<?php } ?>
		<!-- </div> --><!-- container end -->
		<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
		
		<hr>
		
		<!-- 
		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>
 		-->
		<footer >
		
			<!-- <p class="pull-left">&copy; <a href="http://www.kaer.cn/" target="_blank">山东卡尔电器股份有限公司</a> <?php echo date('Y') ?></p> --> 
			<!-- <p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p> -->
			
		</footer>
		<?php } ?>

	
	</div><!--/.fluid-container-->

	
	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	
	<!-- jQuery -->
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script>window.jQuery || document.write('<script src="<?php echo base_url('js/vendor/jquery-1.9.1.js')?>"><\/script>')</script>
   
	<script src="<?php echo base_url('js/vendor/jquery.mb.browser.min.js')?>"></script>
	<!-- jQuery UI -->
	<script src="<?php echo base_url('js/vendor/jquery-ui-1.10.0.custom.min.js')?>"></script>
	<!-- zTree form -->
	<script src="<?php echo base_url('js/vendor/jquery.ztree.core-3.5.min.js') ?>"></script> 
	<script src="<?php echo base_url('js/vendor/jquery.cookie.js')?>"></script>
	
	<script src="<?php echo base_url('js/vendor/json2.js')?>"></script>
	
	<script src="<?php echo base_url('js/jquery.hotkeys.js')?>"></script>
	
	<!-- 表单验证   -->
	<script src="<?php echo base_url('js/vendor/jquery.validate.js')?>"></script>
	
	<script src="<?php echo base_url('js/vendor/jquery.scrollUp.min.js') ?>"></script>
	 
	<script src="<?php echo base_url('js/jquery.noty.js') ?>"></script>
	<!-- data table plugin -->
	<script src="<?php echo base_url('js/jquery.dataTables.min.js') ?>"></script>
	
	<script src="<?php echo base_url('js/jquery-ui-timepicker-addon.js')?>"></script>
	
	
	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--[if lte IE 6]>
		<script type="text/javascript" src="<?php echo base_url('js/vendor/css3-mediaqueries.js') ?>" ></script>
		<script type="text/javascript" src="<?php echo base_url('js/vendor/bootstrap-ie.js')?>"></script>
	<![endif]-->
	
	
	<script src='<?php echo base_url('js/vendor/bootstrap.js')?>'></script> 
	<script src='<?php echo base_url('js/vendor/messenger.min.js')?>'></script> 
	<script src='<?php echo base_url('js/vendor/underscore-1.4.4.js')?>'></script> 
	<!-- backbone need underscore -->
	<script src='<?php echo base_url('js/vendor/backbone.js')?>'></script> 
	
    <script src="<?php echo base_url('js/main.js')?>"></script>
    
    <?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
    	<script src="<?php echo base_url('js/plugins.js')?>"></script>
		<script src="<?php echo base_url('js/pluginCtrl.js') ?>"></script> 
		
	<?php } ?>
	
	
<SCRIPT LANGUAGE=javascript FOR=player EVENT="ReportCameraStatus(info)">
	CamStatusCheck(info);
</SCRIPT>

<SCRIPT LANGUAGE=javascript FOR=player EVENT="TreeStructNotify(info)">
	TreeStructAnalyze(info);
</SCRIPT>


	
	
</body>
</html>
