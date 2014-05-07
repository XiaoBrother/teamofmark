<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>小组列表</title>
<style type="text/css">

<style type="text/css">
body {
	margin: 0px;
	padding: 0px;
	text-align: left;
	color: rgb(85, 85, 85);
	font-family: 宋体, verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}

div {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

img {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

ul {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

li {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

p {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

ul {
	list-style: none;
}

li {
	list-style: none;
}

a:link {
	text-decoration: none;
	color: rgb(85, 85, 85);
}

a:visited {
text-decoration: none;
	color: rgb(130, 0, 110);
	text-decoration: none;
}

a:hover {
text-decoration: none;
	color: rgb(0, 51, 153);
	text-decoration: underline;
}

a:active {
	color: rgb(186, 38, 54);
}

.frame-top {
	height: 88px;
}

.frame-main {
	left: 0px;
	top: 88px;
	right: 0px;
	bottom: 0px;
	position: absolute;
	z-index: 23;
}

.left {
	left: 0px;
	top: 0px;
	bottom: 0px;
	position: absolute;
	width: 201px;
	box-shadow: inset 0px 0px 1px #f8f8f8;
	border: 1px solid #ccc;
}

.right {
	left: 201px;
	top: 0px;
	bottom: 0px;
	position: absolute;
	width: 100%;
	height: 100%;
	box-shadow: inset 0px 0px 1px #f8f8f8;
	border: 1px solid #ccc;
}

.pv {
	background-position: 0px -85px;
	left: 0px;
	width: 100%;
	height: 10px;
	bottom: 0px;
	line-height: 0;
	font-size: 0px;
	position: absolute;
	z-index: 2;
}

.skin-item {
	width: 100%;
	position: absolute;
	z-index: -1;
	background-repeat: no-repeat;
}

.skin-fullScreen {
	left: 0px;
	top: 0px;
	right: 0px;
	bottom: 0px;
	overflow: hidden;
}

.nui-tree-item-label {
	outline: 0px;
	height: 28px;
	line-height: 28px;
	padding-left: 26px;
	margin-right: 1px;
	white-space: nowrap;
	cursor: pointer;
	-ms-zoom: 1;
}

.nui-tree-item-label:hover {
	background: url("http://mimg.127.net/p/js5/lib/img/sceneskin/w30.png")
		repeat scroll 0 0 transparent;
}

.nui-tree-item-label:active {
	background: rgb(245, 245, 245);
}
</style>
</head>
<body>

	<div id="left" class="left">
		<div>
			<div>
				<a href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/teamofmark/index.php/Team/teamdetail">
					新建小组</a>
			</div>

			<ul>
				<li><div id="_mail_component_2_2" class="nui-tree-item-label">
						<span title="我创建的小组" class="nui-tree-item-text">我创建的小组</span>&nbsp;<strong
							class="nui-tree-item-count" id="_mail_tree_1_1count"></strong>
					</div>

					<ul style="" class="nui-tree" role="tree" aria-label="左侧导航">
						<?php if(is_array($myteam)): $i = 0; $__LIST__ = $myteam;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="_mail_tree_13_111" class=" nui-tree-item"><div
								id="_mail_component_112_112" class="nui-tree-item-label">
								<span title="<?php echo ($vo["name"]); ?>" class="nui-tree-item-text"><a
									href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/teamofmark/index.php/Team/team?tid=<?php echo ($vo["teamid"]); ?>"><?php echo ($vo["name"]); ?>
										(微博数 用户数<?php echo ($vo["num"]); ?>)</a> </span>&nbsp;<strong class="nui-tree-item-count"
									id="_mail_tree_13_111count"></strong>
							</div></li><?php endforeach; endif; else: echo "" ;endif; ?>

					</ul></li>

				<li><div id="_mail_component_2_2" class="nui-tree-item-label">
						<span title="我加入的小组" class="nui-tree-item-text">我加入的小组</span>&nbsp;<strong
							class="nui-tree-item-count" id="_mail_tree_1_1count"></strong>
					</div>

					<ul style="" class="nui-tree" role="tree" aria-label="左侧导航">
						<?php if(is_array($team)): $i = 0; $__LIST__ = $team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="_mail_tree_13_111" class=" nui-tree-item"><div
								id="_mail_component_112_112" class="nui-tree-item-label">
								<span title="<?php echo ($vo["name"]); ?>" class="nui-tree-item-text"><a
									href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/index.php/Team/team?tid=<?php echo ($vo["teamid"]); ?>"><?php echo ($vo["name"]); ?>
										(微博数 用户数<?php echo ($vo["num"]); ?>)</a> </span>&nbsp;<strong class="nui-tree-item-count"
									id="_mail_tree_13_111count"></strong>
							</div></li><?php endforeach; endif; else: echo "" ;endif; ?>

					</ul></li>

				<li><div id="_mail_component_2_2" class="nui-tree-item-label">
						<span title="邀请我的小组" class="nui-tree-item-text">邀请我的小组</span>&nbsp;<strong
							class="nui-tree-item-count" id="_mail_tree_1_1count"></strong>
					</div>

					<ul style="" class="nui-tree" role="tree" aria-label="左侧导航">
						<?php if(is_array($jointeam)): $i = 0; $__LIST__ = $jointeam;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id="_mail_tree_13_111" class=" nui-tree-item"><div
								id="_mail_component_112_112" class="nui-tree-item-label">
								<span title="<?php echo ($vo["name"]); ?>" class="nui-tree-item-text"><a
									href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/teamofmark/index.php/Team/team?tid=<?php echo ($vo["teamid"]); ?>"><?php echo ($vo["name"]); ?>
										(微博数 用户数<?php echo ($vo["num"]); ?>)</a> </span>&nbsp;<strong class="nui-tree-item-count"
									id="_mail_tree_13_111count"></strong>
							</div></li><?php endforeach; endif; else: echo "" ;endif; ?>

					</ul></li>

			</ul>
		</div>


	</div>
<title>小组</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>
	// Example: obj = findObj("image1");
	function findObj(theObj, theDoc) {
		var p, i, foundObj;

		if (!theDoc)
			theDoc = document;
		if ((p = theObj.indexOf("?")) > 0 && parent.frames.length) {
			theDoc = parent.frames[theObj.substring(p + 1)].document;
			theObj = theObj.substring(0, p);
		}
		if (!(foundObj = theDoc[theObj]) && theDoc.all)
			foundObj = theDoc.all[theObj];
		for (i = 0; !foundObj && i < theDoc.forms.length; i++)
			foundObj = theDoc.forms[i][theObj];
		for (i = 0; !foundObj && theDoc.layers && i < theDoc.layers.length; i++)
			foundObj = findObj(theObj, theDoc.layers[i].document);
		if (!foundObj && document.getElementById)
			foundObj = document.getElementById(theObj);

		return foundObj;
	}
</script>

<style type="text/css">
body {
	margin: 0px;
	padding: 0px;
	text-align: left;
	color: rgb(85, 85, 85);
	font-family: 宋体, verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}

div {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

img {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

ul {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

li {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

p {
	margin: 0px;
	padding: 0px;
	border: 0px currentColor;
}

ul {
	list-style: none;
}

li {
	list-style: none;
}

a:link {
	text-decoration: none;
	color: rgb(85, 85, 85);
}

a:visited {
text-decoration: none;
	color: rgb(130, 0, 110);
	text-decoration: none;
}

a:hover {
text-decoration: none;
	color: rgb(0, 51, 153);
	text-decoration: underline;
}

a:active {
	color: rgb(186, 38, 54);
}

.frame-top {
	height: 88px;
}

.frame-main {
	left: 0px;
	top: 88px;
	right: 0px;
	bottom: 0px;
	position: absolute;
	z-index: 23;
}

.left {
	left: 0px;
	top: 0px;
	bottom: 0px;
	position: absolute;
	width: 201px;
	box-shadow: inset 0px 0px 1px #f8f8f8;
	border: 1px solid #ccc;
}

.right {
	left: 201px;
	top: 0px;
	bottom: 0px;
	position: absolute;
	width: 100%;
	height: 100%;
	box-shadow: inset 0px 0px 1px #f8f8f8;
	border: 1px solid #ccc;
}

.pv {
	background-position: 0px -85px;
	left: 0px;
	width: 100%;
	height: 10px;
	bottom: 0px;
	line-height: 0;
	font-size: 0px;
	position: absolute;
	z-index: 2;
}

.skin-item {
	width: 100%;
	position: absolute;
	z-index: -1;
	background-repeat: no-repeat;
}

.skin-fullScreen {
	left: 0px;
	top: 0px;
	right: 0px;
	bottom: 0px;
	overflow: hidden;
}

.nui-tree-item-label {
	outline: 0px;
	height: 28px;
	line-height: 28px;
	padding-left: 26px;
	margin-right: 1px;
	white-space: nowrap;
	cursor: pointer;
	-ms-zoom: 1;
}

.nui-tree-item-label:hover {
	background: url("http://mimg.127.net/p/js5/lib/img/sceneskin/w30.png")
		repeat scroll 0 0 transparent;
}

.nui-tree-item-label:active {
	background: rgb(245, 245, 245);
}
</style>

</head>

<body>


	<header class="frame-top">
	<div id="top">
		收藏小组 Team of mark
		<p align="right"><?php echo ($user["screen_name"]); ?></p>

	</div>
	<div class="pv"></div>
	</header>

	<section class="frame-main" role="tabpanel"
		aria-labeledby="h1MainTitle">
	
	<div class="right">
		<iframe name="browserframe" id="browserframe" height="100%"
			width="100%" scrolling="auto" frameborder="0"></iframe>

	</div>
	<!-- <div id="skinFullScreen" class="skin-item skin-fullScreen">
		<img id="skinImg"
			style="opacity: 1; position: absolute; left: auto; top: -389px; height: auto; width: 1440px;"
			src="http://mimg.127.net/p/js5/lib/img/sceneskin/noon.jpg"></img>
	</div>
	 -->
	</section>



</body>
</html>