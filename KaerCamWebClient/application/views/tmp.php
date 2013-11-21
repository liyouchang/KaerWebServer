<?php


<!-- alert enhancer library -->
<script src="<?php echo base_url('js/bootstrap-alert.js') ?>"></script>
<!-- modal / dialog library -->
<script src="<?php echo base_url('js/bootstrap-modal.js') ?>"></script>
<!-- custom dropdown library -->
<script src="<?php echo base_url('js/bootstrap-dropdown.js') ?>"></script>
<!-- scrolspy library -->
<script src="<?php echo base_url('js/bootstrap-scrollspy.js') ?>"></script>
<!-- library for creating tabs -->
<script src="<?php echo base_url('js/bootstrap-tab.js') ?>"></script>
<!-- library for advanced tooltip -->
<script src="<?php echo base_url('js/bootstrap-tooltip.js') ?>"></script>
<!-- popover effect library -->
<script src="<?php echo base_url('js/bootstrap-popover.js') ?>"></script>
<!-- button enhancer library -->
<script src="<?php echo base_url('js/bootstrap-button.js') ?>"></script>
<!-- accordion library (optional, not used in demo) -->
<script src="<?php echo base_url('js/bootstrap-collapse.js') ?>"></script>
<!-- carousel slideshow library (optional, not used in demo) -->
<script src="<?php echo base_url('js/bootstrap-carousel.js') ?>"></script>
<!-- autocomplete library -->
<script src="<?php echo base_url('js/bootstrap-typeahead.js') ?>"></script>
<!-- tour library -->
<script src="<?php echo base_url('js/bootstrap-tour.js') ?>"></script>
/* AJAX 比對資料庫 */
$.post("<?php echo base_url()?>controller_name/check_email_availablity", {
	email: $('#email').val()
}, function(response){
	/* 驗證後讀取 reponse 狀態 */
	$('#Loading').hide();
	setTimeout("finishAjax('Loading', '"+escape(response)+"')", 400);
});

$('.form-horizontal').isHappy({
	fields: {
		'#inputEmail': {
		required: true,
		message: 'Please enter your email',
		test:happy.email
	},
	'#inputPassword': {
	required: true,
	message: 'Please enter password',
		
	}
	},
	doHappy:function(){alert("happy");}
});
	
<ul class="thumbnails gallery ">
							<?php for($i=1;$i<=30;$i++) { ?>
							<li id="image-<?php echo $i ?>" class="thumbnail">
								<div class="iepicture" rel="C:\Camera Pic\2013-2-23\<?php echo $i ?>.bmp" ></div>
								<!-- <a style="background:url(<?php echo base_url("img/gallery/thumbs")."/".$i ?>.jpg)" title="" href="<?php echo base_url("img/gallery")."/".$i ?>.jpg"></a> -->
								<p class="center">Sample Image <?php echo $i ?></p>
							</li>
		
							<?php } ?>
					
						</ul>