<html>
<head>
<title>Web Service</title>

<SCRIPT>
function workaround()
{
	window.document.all.item("ocx").style.display = "none";
	window.document.all.item("ocx").style.display = "";
}
</SCRIPT>

</head>

<form name=activex ><WINDWEB_URL>
<input type=hidden name=url>

</form>

<body  topmargin="0" leftmargin="0" onscroll="workaround();" onload="GetServerIP()">
<div align="center">
<table border="0" cellspacing="0" cellpadding="0" id = "table" width="100%" height="100%">
<tr>
<td bgcolor="#E0E8F2" valign="top" colspan="2" align="center" >

<object classid="clsid:B4273916-4981-4AA8-94F0-3E127191D862"
		standby="Waiting..." id="NetOCX" codebase="#version=1,0,8,123" name="ocx" align="top" width="1000" height="600">
		<a href="./WebClientCtrl.msi">&#31934;&#35013;web&#25511;&#20214;&#19979;&#36733;&#65292;&#23433;&#35013;&#21069;&#20851;&#38381;&#25152;&#26377;&#27983;&#35272;&#22120;</a>
		</object>
		<script language="javascript">
		document.onkeydown   =   function()
		{
			if(window.event.keyCode   ==   8)   //退格删除键
			{
				var   e   =   window.event.srcElement;
				if(e.tagName!="TEXTAREA"   &&
						!(e.tagName=="INPUT"   &&
								(e.type=="text"   ||
										e.type=="password"   ||
										e.type=="file")))
				{
					window.event.keyCode   =   0;
					window.event.returnValue   =   true;
				}
			}
			if(window.event.keyCode   ==   37 || window.event.keyCode == 39)  //左右方向键
			{
				window.event.keyCode   =   0;
				window.event.returnValue   =   true;
			}
		}
		function GetServerIP() {
			var ip=window.location.host;
			if(ip=="")ip="127.0.0.1";
			//ip="192.168.2.197"
			//NetOCX.GetIP(ip);
			NetOCX.DoLogin("lcx","1");
		}
		</script>
		</td>
		</tr>
		<center>
		</table>
		</div>
		</body>
</html>