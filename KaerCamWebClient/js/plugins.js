// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
    
    
}());

// Place any jQuery/helper plugins in here.
$(document).ready(function(){

	
	//验证设置
	$.validator.setDefaults({
		errorPlacement:function(label, element ){
			if($(element).parent().hasClass("checkbox"))
			{
				label.insertAfter($(element).parent());
			}
			else
			{
				label.insertAfter($(element));
			}
		},
		highlight: function( element, errorClass, validClass ) {
			if ( element.type === "radio" ) {
				this.findByName(element.name).addClass(errorClass).removeClass(validClass);
			} else {
				$(element).parents(".control-group").addClass(errorClass).removeClass(validClass);  
				//$(element).addClass(errorClass).removeClass(validClass);
			}
		},
		unhighlight: function( element, errorClass, validClass ) {
			if ( element.type === "radio" ) {
				this.findByName(element.name).removeClass(errorClass).addClass(validClass);
			} else {
				$(element).parents(".error").removeClass(errorClass).addClass(validClass);  
				//$(element).removeClass(errorClass).addClass(validClass);
			}
		},
		errorClass: "error",
		validClass: "",
		errorElementClass: 'help-inline' ,
		errorElement: "span"
			
	});
	
	//datepicker & datetimepicke
	$.datepicker.regional['zh'] = {
			closeText: '关闭',
			prevText: '&#x3C;上月',
			nextText: '下月&#x3E;',
			currentText: '今天',
			monthNames: ['一月','二月','三月','四月','五月','六月',
			'七月','八月','九月','十月','十一月','十二月'],
			monthNamesShort: ['一月','二月','三月','四月','五月','六月',
			'七月','八月','九月','十月','十一月','十二月'],
			dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
			dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
			dayNamesMin: ['日','一','二','三','四','五','六'],
			weekHeader: '周',
			dateFormat: 'yy/mm/dd',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: true,
			yearSuffix: '年',
			changeMonth: true,
			changeYear: true
	};
			
	//disbaling some functions for Internet Explorer
	//$('.login-box').find('.input-large').removeClass('span10');
	//bind to State Change

	$('#content').ajaxStart(function(e){
		alert("start");
		$(this).fadeOut().parent().append('<div id="loading" class="center">Loading...<div class="center"></div></div>');
		
	});
	$('#content').ajaxStop(function(){
		$('#loading').remove();
		$('#content').fadeIn();	
	});
	
	
	//highlight current / active link
	$('ul.main-menu li a').each(function(){
		if($($(this))[0].href==String(window.location))
			;//$(this).parent().addClass('active');
	});
	
	//animating menus on hover
	$('ul.main-menu li:not(.nav-header)').hover(function(){
		$(this).animate({'margin-left':'+=5'},300);
	},
	function(){
		$(this).animate({'margin-left':'-=5'},300);
	});
	
	// side bar
	$('.sidebar-nav').affix({offset: {top:  100, bottom: 100}});
 
	//other things to do on document ready, seperated for ajax calls
	docReady();
});

		
function docReady(){
	//prevent # links from moving to top
	$('a[href="#"][data-top!=true]').click(function(e){
		e.preventDefault();
	});

	$('.datepicker').datepicker($.datepicker.regional['zh']);
	$('.datetimepicker').datetimepicker({
		currentText:"现在",
		closeText:"确定",
		timeOnlyTitle:"选择时间",
		timeText:"时间",
		hourText:"时",
		minuteText:"分",
		secondText:"秒",
		timeFormat:"HH:mm:ss",
		showSecond: true
			
	});
	//notifications
	$('.noty').click(function(e){
		e.preventDefault();
		var options = $.parseJSON($(this).attr('data-noty-options'));
		noty(options);
	});
	//tabs
	$('#myTab a:first').tab('show');
	$('#myTab a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});

	
	//makes elements soratble, elements that sort need to have id attribute to save the result
	$('.sortable').sortable({
		revert:true,
		cancel:'.btn,.box-content,.nav-header',
		update:function(event,ui){
			//line below gives the ids of elements, you can make ajax call here to save it to the database
			//console.log($(this).sortable('toArray'));
		}
	});

	//slider
	$('.slider').slider({range:true,values:[10,65]});

	//tooltip
	$('[rel="tooltip"],[data-rel="tooltip"]').tooltip({"placement":"bottom",delay: { show: 400, hide: 200 }});

	//popover
	$('[rel="popover"],[data-rel="popover"]').popover({trigger:'hover',placement: 'bottom'});

	//gallery controlls container animation
	$('ul.gallery li').hover(function(){
		$('img',this).fadeToggle(1000);
		$(this).find('.gallery-controls').remove();
		$(this).append('<div class="well gallery-controls">'+
							'<p><a href="#" class="gallery-edit btn"><i class="icon-edit"></i></a> <a href="#" class="gallery-delete btn"><i class="icon-remove"></i></a></p>'+
						'</div>');
		$(this).find('.gallery-controls').stop().animate({'margin-top':'-1'},400,'easeInQuint');
	},function(){
		$('img',this).fadeToggle(1000);
		$(this).find('.gallery-controls').stop().animate({'margin-top':'-30'},200,'easeInQuint',function(){
				$(this).remove();
		});
	});
		
	//gallery image controls example
	//gallery delete
	$('.thumbnails').on('click','.gallery-delete',function(e){
		e.preventDefault();
		//get image id
		//alert($(this).parents('.thumbnail').attr('id'));
		$(this).parents('.thumbnail').fadeOut();
	});
	//gallery edit
	$('.thumbnails').on('click','.gallery-edit',function(e){
		e.preventDefault();
		//get image id
		//alert($(this).parents('.thumbnail').attr('id'));
	});

	//datatable
	$('.datatable').dataTable({
			"sDom": "<'row-fluid'<'span7'l><'span5'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				  "sLengthMenu": "每页显示  _MENU_  条记录",
			      "sZeroRecords": "对不起，查询不到任何相关数据",
			      "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
			      "sInfoEmtpy": "找不到相关数据",
			      "sInfoFiltered": "数据表中共为 _MAX_ 条记录)",
			      "sProcessing": "正在加载中...",
			      "sSearch": "搜索",
			      "sUrl": "", //多语言配置文件，可将oLanguage的设置放在一个txt文件中，例：Javascript/datatable/dtCH.txt
			      "oPaginate": {
			          "sFirst":    "第一页",
			          "sPrevious": " 上一页 ",
			          "sNext":     " 下一页 ",
			          "sLast":     " 最后一页 "
			      }
			}
		} );
	$('.btn-close').click(function(e){
		e.preventDefault();
		$(this).parent().parent().parent().fadeOut();
	});
	$('.btn-minimize').click(function(e){
		e.preventDefault();
		var $target = $(this).parent().parent().next('.box-content');
		if($target.is(':visible')) $('i',$(this)).removeClass('icon-chevron-up').addClass('icon-chevron-down');
		else 					   $('i',$(this)).removeClass('icon-chevron-down').addClass('icon-chevron-up');
		$target.slideToggle();
	});
	$('.btn-setting').click(function(e){
		e.preventDefault();
		$('#myModal').modal('show');
	});
	
	//初始化插件
	initPlugin();
	
	// we use an inline data source in the example, usually data would
	// be fetched from a server
	var data = [], totalPoints = 300;
	function getRandomData() {
		if (data.length > 0)
			data = data.slice(1);
		// do a random walk
		while (data.length < totalPoints) {
			var prev = data.length > 0 ? data[data.length - 1] : 50;
			var y = prev + Math.random() * 10 - 5;
			if (y < 0)
				y = 0;
			if (y > 100)
				y = 100;
			data.push(y);
		}
		// zip the generated y values with the x values
		var res = [];
		for (var i = 0; i < data.length; ++i)
			res.push([i, data[i]]);
		return res;
	}
	
	
	//
}
//additional functions for data table
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
};

$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>'+
					'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
					'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
				'</ul>'
			);
			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
				// remove the middle elements
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();

				// add the new list items and their event handlers
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
						.insertBefore( $('li:last', an[i])[0] )
						.bind('click', function (e) {
							e.preventDefault();
							oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
							fnDraw( oSettings );
						} );
				}
				// add / remove disabled classes from the static elements
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}

				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}
});


function loadXMLDoc(dname) 
{

try //Internet Explorer
  {
  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  }
catch(e)
  {
  try //Firefox, Mozilla, Opera, etc.
    {
    xmlDoc=document.implementation.createDocument("","",null);
    }
  catch(e) {alert(e.message);}
  }
try 
  {
  xmlDoc.async=false;
  xmlDoc.load(dname);
  return(xmlDoc);
  }
catch(e) {alert(e.message);}
return(null);
}

function loadXMLString(text){
	try {//Internet Explorer
	  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
	  xmlDoc.async="false";
	  xmlDoc.loadXML(text);
	  
	  }
	catch(e){
	  try {//Firefox, Mozilla, Opera, etc.
	    parser=new DOMParser();
	    xmlDoc=parser.parseFromString(text,"text/xml");
	    }
	  catch(e) {
		  alert(e.message);
		  return (null);
		  }
	  }
	return (xmlDoc);
	
}
function get_nextSibling(n)
{
	y=n.nextSibling;
	while (y.nodeType!=1)
	  {
	  y=y.nextSibling;
	  }
	return y;
}
function get_firstChild(n)
{
y=n.firstChild;
while (y.nodeType!=1)
  {
  y=y.nextSibling;
  }
return y;
}


