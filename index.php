<?php
include_once 'main/_lib/config.php';

// Redirect users to app.php including the appropriate GET variables if loaded through facebook (iframe)
if (array_key_exists('fb_sig_in_iframe', $_REQUEST)) {
	$params = $_SERVER['QUERY_STRING'];
	$redirectURL = "main/index.php?" . $params;
	header('Location: ' . $redirectURL);
} else {
	// Loading through the Connect site
	// Ensure that the URL is prefixed with 'WWW', otherwise facebook's cookies can get messed up.
	$url = $_SERVER['SERVER_NAME'];
	$page = $_SERVER['PHP_SELF'];

	$substr = substr($base_url, 7);
	if ($url != $substr) {
		$redirectURL = $base_url.$page;
		header('Location: ' . $redirectURL);
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Description" content="Socialfly: be twice the friend in half the time">

	<title>Socialfly: 2x Friend, 1/2 Time</title>
	<link rel="stylesheet" type="text/css" href="about.css" />
	<script language="JavaScript" type="text/javascript">
	<!--
	//v1.7
	// Flash Player Version Detection
	// Detect Client Browser type
	// Copyright 2005-2008 Adobe Systems Incorporated.  All rights reserved.
	var isIE  = (navigator.appVersion.indexOf("MSIE") != -1) ? true : false;
	var isWin = (navigator.appVersion.toLowerCase().indexOf("win") != -1) ? true : false;
	var isOpera = (navigator.userAgent.indexOf("Opera") != -1) ? true : false;
	function ControlVersion()
	{
		var version;
		var axo;
		var e;
		// NOTE : new ActiveXObject(strFoo) throws an exception if strFoo isn't in the registry
		try {
			// version will be set for 7.X or greater players
			axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
			version = axo.GetVariable("$version");
		} catch (e) {
		}
		if (!version)
		{
			try {
				// version will be set for 6.X players only
				axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");

				// installed player is some revision of 6.0
				// GetVariable("$version") crashes for versions 6.0.22 through 6.0.29,
				// so we have to be careful. 

				// default to the first public version
				version = "WIN 6,0,21,0";
				// throws if AllowScripAccess does not exist (introduced in 6.0r47)		
				axo.AllowScriptAccess = "always";
				// safe to call for 6.0r47 or greater
				version = axo.GetVariable("$version");
			} catch (e) {
			}
		}
		if (!version)
		{
			try {
				// version will be set for 4.X or 5.X player
				axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
				version = axo.GetVariable("$version");
			} catch (e) {
			}
		}
		if (!version)
		{
			try {
				// version will be set for 3.X player
				axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.3");
				version = "WIN 3,0,18,0";
			} catch (e) {
			}
		}
		if (!version)
		{
			try {
				// version will be set for 2.X player
				axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
				version = "WIN 2,0,0,11";
			} catch (e) {
				version = -1;
			}
		}

		return version;
	}
	// JavaScript helper required to detect Flash Player PlugIn version information
	function GetSwfVer(){
		// NS/Opera version >= 3 check for Flash plugin in plugin array
		var flashVer = -1;

		if (navigator.plugins != null && navigator.plugins.length > 0) {
			if (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]) {
				var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
				var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
				var descArray = flashDescription.split(" ");
				var tempArrayMajor = descArray[2].split(".");			
				var versionMajor = tempArrayMajor[0];
				var versionMinor = tempArrayMajor[1];
				var versionRevision = descArray[3];
				if (versionRevision == "") {
					versionRevision = descArray[4];
				}
				if (versionRevision[0] == "d") {
					versionRevision = versionRevision.substring(1);
				} else if (versionRevision[0] == "r") {
					versionRevision = versionRevision.substring(1);
					if (versionRevision.indexOf("d") > 0) {
						versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
					}
				}
				var flashVer = versionMajor + "." + versionMinor + "." + versionRevision;
			}
		}
		// MSN/WebTV 2.6 supports Flash 4
		else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.6") != -1) flashVer = 4;
		// WebTV 2.5 supports Flash 3
		else if (navigator.userAgent.toLowerCase().indexOf("webtv/2.5") != -1) flashVer = 3;
		// older WebTV supports Flash 2
		else if (navigator.userAgent.toLowerCase().indexOf("webtv") != -1) flashVer = 2;
		else if ( isIE && isWin && !isOpera ) {
			flashVer = ControlVersion();
		}	
		return flashVer;
	}
	// When called with reqMajorVer, reqMinorVer, reqRevision returns true if that version or greater is available
	function DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision)
	{
		versionStr = GetSwfVer();
		if (versionStr == -1 ) {
			return false;
		} else if (versionStr != 0) {
			if(isIE && isWin && !isOpera) {
				// Given "WIN 2,0,0,11"
				tempArray         = versionStr.split(" "); 	// ["WIN", "2,0,0,11"]
				tempString        = tempArray[1];			// "2,0,0,11"
				versionArray      = tempString.split(",");	// ['2', '0', '0', '11']
			} else {
				versionArray      = versionStr.split(".");
			}
			var versionMajor      = versionArray[0];
			var versionMinor      = versionArray[1];
			var versionRevision   = versionArray[2];
	        	// is the major.revision >= requested major.revision AND the minor version >= requested minor
			if (versionMajor > parseFloat(reqMajorVer)) {
				return true;
			} else if (versionMajor == parseFloat(reqMajorVer)) {
				if (versionMinor > parseFloat(reqMinorVer))
					return true;
				else if (versionMinor == parseFloat(reqMinorVer)) {
					if (versionRevision >= parseFloat(reqRevision))
						return true;
				}
			}
			return false;
		}
	}
	function AC_AddExtension(src, ext)
	{
	  if (src.indexOf('?') != -1)
	    return src.replace(/\?/, ext+'?'); 
	  else
	    return src + ext;
	}
	function AC_Generateobj(objAttrs, params, embedAttrs) 
	{ 
	  var str = '';
	  if (isIE && isWin && !isOpera)
	  {
	    str += '<object ';
	    for (var i in objAttrs)
	    {
	      str += i + '="' + objAttrs[i] + '" ';
	    }
	    str += '>';
	    for (var i in params)
	    {
	      str += '<param name="' + i + '" value="' + params[i] + '" /> ';
	    }
	    str += '</object>';
	  }
	  else
	  {
	    str += '<embed ';
	    for (var i in embedAttrs)
	    {
	      str += i + '="' + embedAttrs[i] + '" ';
	    }
	    str += '> </embed>';
	  }
	  document.write(str);
	}
	function AC_FL_RunContent(){
	  var ret = 
	    AC_GetArgs
	    (  arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
	     , "application/x-shockwave-flash"
	    );
	  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
	}
	function AC_SW_RunContent(){
	  var ret = 
	    AC_GetArgs
	    (  arguments, ".dcr", "src", "clsid:166B1BCA-3F9C-11CF-8075-444553540000"
	     , null
	    );
	  AC_Generateobj(ret.objAttrs, ret.params, ret.embedAttrs);
	}
	function AC_GetArgs(args, ext, srcParamName, classid, mimeType){
	  var ret = new Object();
	  ret.embedAttrs = new Object();
	  ret.params = new Object();
	  ret.objAttrs = new Object();
	  for (var i=0; i < args.length; i=i+2){
	    var currArg = args[i].toLowerCase();    
	    switch (currArg){	
	      case "classid":
	        break;
	      case "pluginspage":
	        ret.embedAttrs[args[i]] = args[i+1];
	        break;
	      case "src":
	      case "movie":	
	        args[i+1] = AC_AddExtension(args[i+1], ext);
	        ret.embedAttrs["src"] = args[i+1];
	        ret.params[srcParamName] = args[i+1];
	        break;
	      case "onafterupdate":
	      case "onbeforeupdate":
	      case "onblur":
	      case "oncellchange":
	      case "onclick":
	      case "ondblclick":
	      case "ondrag":
	      case "ondragend":
	      case "ondragenter":
	      case "ondragleave":
	      case "ondragover":
	      case "ondrop":
	      case "onfinish":
	      case "onfocus":
	      case "onhelp":
	      case "onmousedown":
	      case "onmouseup":
	      case "onmouseover":
	      case "onmousemove":
	      case "onmouseout":
	      case "onkeypress":
	      case "onkeydown":
	      case "onkeyup":
	      case "onload":
	      case "onlosecapture":
	      case "onpropertychange":
	      case "onreadystatechange":
	      case "onrowsdelete":
	      case "onrowenter":
	      case "onrowexit":
	      case "onrowsinserted":
	      case "onstart":
	      case "onscroll":
	      case "onbeforeeditfocus":
	      case "onactivate":
	      case "onbeforedeactivate":
	      case "ondeactivate":
	      case "type":
	      case "codebase":
	      case "id":
	        ret.objAttrs[args[i]] = args[i+1];
	        break;
	      case "width":
	      case "height":
	      case "align":
	      case "vspace": 
	      case "hspace":
	      case "class":
	      case "title":
	      case "accesskey":
	      case "name":
	      case "tabindex":
	        ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];
	        break;
	      default:
	        ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
	    }
	  }
	  ret.objAttrs["classid"] = classid;
	  if (mimeType) ret.embedAttrs["type"] = mimeType;
	  return ret;
	}
	// -->
	</script>
</head>

<body id="overview">
<div id="productheader">
	<h2><img src="images/socialfly.png" width="175" height="50" /></h2>
	<ul>
		<li><a class="selected">Home</a></li>
		<li><a href="about.html">About</a></li>
		<li><a href="testimonials.html">Testimonials</a></li>
		<li><a href="http://social-fly.com/blog">Blog</a></li>
		<li><a href="main/index.php" class="connect"><img id="fb_login_image" alt="Connect with Facebook" src="images/loginfbconnect.gif"/></a></li>
	</ul>
</div>
<div id="container">
	<div style="z-index:1; position:absolute; top:10px; left:665px;"><img src="images/iphone.png"/></div>
	<div id="main">
		<div id="content">
			<div id="hero">
				<h1 class="replaced">Twice the friend in half the time.</h1>
				<p class="intro people">
					Socialfly gives you the tools to organize your social life and keep up with more people. <a class="more" href="about.html">Tell me more</a>
				</p>
				<script language="JavaScript" type="text/javascript">
					AC_FL_RunContent(
						'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0',
						'width', '500',
						'height', '415',
						'src', 'about/socialfly',
						'quality', 'high',
						'pluginspage', 'http://www.adobe.com/go/getflashplayer',
						'align', 'middle',
						'play', 'false',
						'loop', 'true',
						'scale', 'showall',
						'wmode', 'window',
						'devicefont', 'false',
						'id', 'about/socialfly',
						'bgcolor', '#efefef',
						'name', 'about/socialfly',
						'menu', 'true',
						'allowFullScreen', 'false',
						'allowScriptAccess','sameDomain',
						'movie', 'images/socialfly',
						'salign', ''
						); //end AC code
				</script>
				<noscript>
					<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="500" height="415" id="about/socialfly" align="middle">
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="allowFullScreen" value="false" />
					<param name="movie" value="images/socialfly.swf" /><param name="play" value="false" /><param name="quality" value="high" /><param name="bgcolor" value="#efefef" />	<embed src="images/socialfly.swf" play="false" quality="high" bgcolor="#efefef" width="500" height="415" name="about/socialfly" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />
					</object>
				</noscript>
				<h3 style="clear:both;padding:5px 0px 5px 0px;text-align:center;width:100%;line-height:1.5em;font-family:Helvetica;font-weight:bold;font-size:18px;"><a href="main/" class="connect" style="color:#ffa800;">Click below to start using Socialfly<br/><img id="fb_login_image" alt="Connect" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_white_large_long.gif"/></a></h3>

			</div>
		</div>
	</div>
	<div id="grid">
		<div id="triselect">
			<div class="grid4col">
				<ul>
					<li class="first">
						<img width="139" height="139" border="0" src="images/glass-keepup.png"/>
						<h2>Keep Up</h2>
						<p>Set reminders to talk. Never forget a friend.</p>
					</li>
					<li>
						<img width="139" height="139" border="0" src="images/glass-organize.png"/>
						<h2>Organize Friends</h2>                           
						<p>Remember who they are.<BR/></p>                       
					</li>                                                
					<li>                                  
						<img width="139" height="139" border="0" src="images/glass-maps.png"/>
						<h2>Friend Maps</h2>
						<p>When you travel you'll know who to visit.</p>
					</li>
					<li class="last">
						<img width="139" height="139" border="0" src="images/glass-privatefeed.png"/>
						<h2>Private Feed</h2>
						<p>Write notes, make plans, and keep track of favors.</p>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5708981-4");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
