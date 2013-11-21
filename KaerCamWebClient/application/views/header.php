 <!DOCTYPE html>

<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="zh"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="zh"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="zh"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="zh" > <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title?></title>
	<meta name="description" content="Kaer web camera client system.">
	<meta name="viewport" content="width=device-width">
	<meta name="author" content="lht">
	<!-- The styles -->
	<link href='<?php echo base_url('css/bootstrap.css') ?>' rel='stylesheet'>
	<link href="<?php echo base_url('css/jquery-ui-1.10.0.custom.css')?>" rel="stylesheet">
	<link type="text/css" href="<?php echo base_url('css/font-awesome.min.css') ?>" rel="stylesheet" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo base_url('css/font-awesome-ie7.min.css') ?>">
    <![endif]-->
    <!--[if lt IE 9]>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('css/jquery.ui.1.10.0.ie.css')?>"/>
	<![endif]-->
	
	
	<link href='<?php echo base_url('css/jquery.noty.css') ?>' rel='stylesheet'>
	<link href='<?php echo base_url('css/noty_theme_default.css') ?>' rel='stylesheet'>
	<!-- <link href='<?php echo base_url('css/jquery.dataTables.css') ?>' rel='stylesheet'> -->
	
	<link href='<?php echo base_url('css/opa-icons.css')?>' rel='stylesheet'>
	<link href='<?php echo base_url('css/jquery-ui-timepicker-addon.css') ?>' rel='stylesheet'>
	<link href='<?php echo base_url('css/zTreeStyle.css') ?>' rel='stylesheet'>
	<link href='<?php echo base_url('css/tupian.css') ?>' rel='stylesheet'>

	
	
	<link href="<?php echo base_url('css/myapp.css')?>" rel="stylesheet">
	
	<!-- <link href="<?php echo base_url('css/bootstrap-responsive.css') ?>" rel="stylesheet"> --> 
	<!--[if lte IE 6]>
  		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/bootstrap-ie6.css')?>">
  	<![endif]-->
  	<!--[if lte IE 7]>
  		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/ie.css')?>">
  	<![endif]-->
  	
  	<link rel="stylesheet" href="<?php echo base_url('css/messenger.css')?>">
	<link rel="stylesheet" href="<?php echo base_url('css/messenger-theme-future.css')?>">
	
	<link rel="stylesheet" href="<?php echo base_url('css/normalize.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('css/main.css')?>">
	

	<script type="text/javascript">
	SITE_URL = "<?php echo site_url() ?>";
	BASE_URL = "<?php echo base_url()?>";
	CENTER_SVR_IP = "<?php echo $centerSvrIp ?>";
	PLUGIN_FILE_PATH = "<?php echo $pluginFilePath ?>";
	CENTER_SVR_TYPE= <?php echo $centerSvrType;?>;
	SHARE_PERMISSION= <?php echo $sharePermission?>;
	</script>
	
	
	<script src="<?php echo base_url('js/vendor/modernizr-2.6.2.min.js')?>"></script>
	 
	
	<!-- The fav icon -->
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="<?php echo base_url('img/favicon.ico')?>">
		
</head>

<body >
	<?php if((!isset($no_visible_elements) || !$no_visible_elements) )	{ ?>
	

	<!-- topbar starts -->
	<div class="navbar navbar-inverse " id="main-navbar">
		<div class="navbar-inner" >
			<div class="container">
				<a class="brand logo" href='#'> <img alt="Logo" src="<?php echo base_url('img/logo20.png')?>" /> <span>视频监控系统</span></a>
				
				<ul class=" nav nav-tabs nav-stacked main-menu ">
					<li id="menu-monitoring" class="success dropdown"><a class="dropdown-toggle" href="monitoring"><i class="icon-facetime-video"></i><span class="hidden-tablet"> 实时监控</span></a></li>
					<li id="menu-recorder" class="success dropdown"><a class="dropdown-toggle" href="record_view"><i class="icon-film"></i><span class="hidden-tablet"> 录像播放</span></a></li>
					<li  id="menu-sysParam" class="success dropdown"><a class="dropdown-toggle" href="sys_config"><i class="icon-edit"></i><span class="hidden-tablet"> 系统配置</span></a></li>
				<!-- 
				<a class="brand logo" href=<?php  echo base_url("start/my_camera")?>> <img alt="Logo" src="<?php echo base_url('img/logo20.png')?>" /> <span>视频监控系统</span></a>
						<li class="success dropdown"><a class="ajax-link dropdown-toggle" rel="monitoring"><i class="icon-facetime-video"></i><span class="hidden-tablet"> 实时监控</span></a></li>
						<li class="success dropdown"><a class="ajax-link dropdown-toggle" rel="record_view"><i class="icon-film"></i><span class="hidden-tablet"> 录像播放</span></a></li>
						<li class="success dropdown"><a class="ajax-link dropdown-toggle" rel="alarms_query"><i class="icon-list-alt"></i><span class="hidden-tablet"> 告警查询</span></a></li>
						<li class="success dropdown"><a class="ajax-link dropdown-toggle" rel="snap_gallery"><i class="icon-camera"></i><span class="hidden-tablet"> 快照查询</span></a></li>
						 
						<li class="success dropdown">
						<a class="ajax-link dropdown-toggle"  rel="sys_config"><i class="icon-cog"></i><span class="hidden-tablet"> 系统配置</span></a>
						<ul class="dropdown-menu">
						<li><a class="ajax-link" rel="home"><i class="icon-user"></i><span class="hidden-tablet"> 账户设置</span></a></li>
						<li class="divider"></li> 
						<li><a href="<?php  echo base_url('login/logout')?>"><i class="icon-lock"></i><span class="hidden-tablet"> 退出登录</span></a></li>
						</ul>
						</li>
						-->
						
				</ul>
				<!-- user dropdown starts -->
				<div class="btn-group pull-right usermenu " >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> <?php echo '登录用户：'.$userName?></span>
						 <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<!-- 
						<li><a class="" href="home"><i class="icon-user"></i><span class="hidden-tablet"> 账户设置</span></a></li>
						<li class="divider"></li>
						 --> 
						<li><a href="<?php  echo base_url('login/logout')?>"><i class="icon-lock"></i><span class="hidden-tablet"> 退出登录</span></a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
	<?php } ?>
	<div class="container">
	
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) { ?>
		

			<div id="content" class="">
			 
			<div id="content-inner" >
			
			<!-- content starts -->
			<?php } ?>
