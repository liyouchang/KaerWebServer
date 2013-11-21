<?php include('header.php'); ?>

<SCRIPT type="text/javascript">
<!--
		var setting = {
			data: {
				simpleData: {
					enable: true
				}
			},
			view: {
				//fontCss: getFontCss,
				selectedMulti: true
			}
		};

		var zNodes =[
			{ id:1, pId:0, name:"江苏公安", open:true, iconSkin:"home"},
			{ id:11, pId:1, name:"威海食品", iconSkin:"home"},
			{ id:111, pId:11, name:"encoder1111111111", iconSkin:"encoder"},
			{ id:1112, pId:111, name:"encoder1111111111", iconSkin:"encoder"},
			{ id:11121, pId:1112, name:"encoder1111111111", iconSkin:"encoder"},
			{ id:111211, pId:11121, name:"encoder1111111111", iconSkin:"encoder"},
			{ id:1112111, pId:111211, name:"encoder1111111111", iconSkin:"encoder"},
			{ id:11121111, pId:1112111, name:"encoder1111111dddffsdfs31231231231231231231231331213212111", iconSkin:"encoder"},
			{ id:1111,pId:111,name:"camera",iconSkin:"camera"},
			{ id:112, pId:11, name:"encoder2", iconSkin:"encoderOffline"},
			{ id:1121,pId:112,name:"camera",iconSkin:"camera"},
			{ id:12, pId:1, name:"测试", iconSkin:"home"},
			{ id:121, pId:12, name:"测试1", iconSkin:"home"},
			{ id:1211, pId:121, name:"测试11", iconSkin:"home"},
			{ id:12111, pId:1211, name:"encoder11", iconSkin:"encoder"},
			{ id:121111,pId:12111,name:"camera1",iconSkin:"camera"},
			{ id:121112,pId:12111,name:"camera1",iconSkin:"camera"},
			{ id:1212, pId:121, name:"测试12", iconSkin:"home"},
			{ id:12121, pId:1212, name:"encoder1", iconSkin:"encoder"},
			{ id:122, pId:12, name:"encoder1", iconSkin:"encoder"},
			{ id:1111,pId:111,name:"camera1",iconSkin:"camera"},
			{ id:112, pId:12, name:"encoder2", iconSkin:"encoderOffline"},
			{ id:1121,pId:112,name:"camera2",iconSkin:"camera"},

		];
		var nodeList = [];
		var lastValue = "";
		function searchCamera() {
			var zTree = $.fn.zTree.getZTreeObj("treeDemo");
			var keyType = "name";
			var value = $.trim( $("#camKey").get(0).value);
			//if (lastValue === value) return;
			//lastValue = value;
			
			if (value === "") 
			{
				//zTree.cancelSelectedNode();
				return;
			}
			
			//updateNodes(false);
			nodeList = zTree.getNodesByParamFuzzy(keyType, value);
					
			zTree.cancelSelectedNode();
			//zTree.expandAll(false);
			for( var i=0, l=nodeList.length; i<l; i++) {
				//nodeList[i].highlight = highlight;
				//zTree.updateNode(nodeList[i]);
				zTree.selectNode(nodeList[i],true );
			}
		}
		
		function getFontCss(treeId, treeNode) {
			
			return (!!treeNode.highlight) ? {"font-weight":"bold","background-color":"green"} : {"font-weight":"normal", "background-color":"transparent"};
		}


		
		$(document).ready(function(){
			$.fn.zTree.init($("#treeDemo"), setting, zNodes);
			
		});
		
		//-->
		function doWatch(fileid,ftpPath)
		{
			
			this.document.getElementById("picDiv").style.display="block";
			operFlag = 1;
			document.getElementById("picture").filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = "../images/default.jpg";
			if(queryType == 2)
			{
				
				document.getElementById("picture").filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = fileid;
			}
			else
			{
				var index2 = fileid.lastIndexOf(".");
			    var infoId = fileid.substring(0,index2);		
				var player = document.getElementById("player");
				var defaultPath = player.GetDefaultSnapPath();
				var downrtn = player.SnapFileDownload(guId,queryType,fileid,ftpPath,defaultPath);
				if(downrtn!=200 && downrtn != 204)
				{
					$infoShow("downInfo_" + infoId, '图片加载失败');
				}
				else
				{
					$infoShow("downInfo_" + infoId, '请等待，图片正在加载');
				}
			}
		}
		
</SCRIPT>


			<div>
				<ul class="breadcrumb">
					<li>
						<a href="home">视频监控功能</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><?php echo $title?></a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid">
				
				<div class="box span3">
					<div class="box-header well" data-original-title>
						<h2><i class=""></i> 摄像头信息表</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="form-search">
  							<input type="text" id="camKey" value="" class="input-medium search-query" placeholder="镜头名称" >
 							<button type="button" class="btn " onclick="searchCamera()">
 							<i class="icon-search"></i>查找</button>
						</div>
						<div class="zTreeBackground ">
							<ul id="treeDemo" class="ztree"></ul>
						</div>
					</div>
				</div><!--/span-->
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-picture"></i> Gallery</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					
						<div id="divhead">
								<p class="center">Sample Image 111</p>
						</div>
					</div>
				</div><!--/span-->
			</div><!--/row-->
    
<?php include('footer.php'); ?>
