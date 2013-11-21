<?php  include('header.php'); ?>

	<!-- 
			<div>
				<ul class="breadcrumb ">
					<li>
						<a >视频监控功能</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><?php echo $title?></a>
					</li>
				</ul>
			</div>
			  -->
			<div class="page-header center ">
				<h1 >欢迎使用视频监控系统</h1>
			</div>
			
			<div class=" row-fluid " >
				<a data-rel="popover" class="well span3 top-block"  href="monitoring" 
				data-content="进入本页面可以观看每个摄像头的实时视频画面，抓拍快照图片，进行录像，设置摄像头告警参数以及查看在线摄像头实时告警信息。" >
					<span class="icon32 icon-color icon-comment-video"></span>
					<div>实时监控</div>
				</a>

				<a data-rel="popover" data-content="播放本地视频。" class="well span3 top-block"   href="record_view">
					<span class="icon32 icon-color icon-video"></span>
					<div>录像播放</div>
				</a>

				<a data-rel="popover" data-content="根据您的查询条件，查询历史告警信息!" class="well span3 top-block"  href="alarms_query">
					<span class="icon32 icon-color icon-alert"></span>
					<div>告警查询</div>
				</a>
		
				<a data-rel="popover" data-content="进入页面可以查询，预览或下载快照" class="well span3 top-block"  href="snap_gallery">
					<span class="icon32 icon-color icon-image"></span>
					<div>快照管理</div>
				</a>
			
			</div>
			<!-- 
			<div  class=" row-fluid " >

             <p id="info" ></p>
			</div>
 -->
	
       
<?php include('footer.php'); ?>
