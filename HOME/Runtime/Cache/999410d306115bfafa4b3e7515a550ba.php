<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript"
	src="__ROOT__/HOME/Tpl/js/jquery-1.7.2.min.js"></script>
<title>小组列表</title>
<style type="text/css">
body {
	width: 980px;
	margin: auto
}

li {
	list-style-type: none;
}

.right {
	float: right;
	padding-top: 3px;
	border-top: 1px solid rgb(220, 220, 220);
	border-bottom: 1px solid rgb(220, 220, 220);
	width: 210px;
	color: #C8C8C8;
}

.right .ul {
	float: left;
	padding-left: 0px;
	text-align: left;
	width: 210px;
}

.right .ul li {
	padding-left: 0px;
}

.right .ul li a {
	color: rgb(102, 102, 102);
	line-height: 25px;
	display: block;
}

.right .ul li a:hover {
	background-color: rgb(244, 244, 244);
	text-decoration: none;
	text-decoration: underline;
}

.right .ul li a:link {
	text-decoration: none;
	background-color: rgb(110, 191, 195)
}

.right .ul li a:visited {
	text-decoration: none;
	text-decoration: none;
}

.right h2 {
	float: left;
	font-family: "微软雅黑";
	cursor: pointer;
	padding-left: 0px;
}

.tm_ul {
	float: left;
	margin-top:0px;
	padding-left: 5px;
}
.tm_ul li{
	padding-left: 5px;
}
</style>
</head>
<body>

	<div id="right" class="right">
		<ul class="ul">
			<li><a
				href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/teamofmark/index.php/Team/teamdetail">
					新建小组</a></li>
			<li><h2 title="我创建的小组" class="title">我创建的小组</h2>
				<ul style="display: block;" class="tm_ul">
					<?php if(is_array($myteam)): $i = 0; $__LIST__ = $myteam;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a
						href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/teamofmark/index.php/Team/team?tid=<?php echo ($vo["teamid"]); ?>"><?php echo ($vo["name"]); ?>
							(微博数 用户数<?php echo ($vo["num"]); ?>)</a></li><?php endforeach; endif; else: echo "" ;endif; ?>

				</ul></li>
			<li>
				<h2 title="我加入的小组" class="title">我加入的小组</h2>
				<ul style="display: block;" class="tm_ul">
					<?php if(is_array($team)): $i = 0; $__LIST__ = $team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a
						href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/index.php/Team/team?tid=<?php echo ($vo["teamid"]); ?>"><?php echo ($vo["name"]); ?>
							(微博数 用户数<?php echo ($vo["num"]); ?>)</a></li><?php endforeach; endif; else: echo "" ;endif; ?>

				</ul>
			</li>
			<li>
				<h2 title="邀请我的小组" class="title">邀请我的小组</h2>
				<ul style="display: none;" class="tm_ul">
					<?php if(is_array($jointeam)): $i = 0; $__LIST__ = $jointeam;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a
						href="http://<?php echo ($_SERVER['HTTP_HOST']); ?>/teamofmark/index.php/Team/team?tid=<?php echo ($vo["teamid"]); ?>"><?php echo ($vo["name"]); ?>
							(微博数 用户数<?php echo ($vo["num"]); ?>)</a></li><?php endforeach; endif; else: echo "" ;endif; ?>

				</ul>
			</li>

		</ul>
	</div>
	<script type="text/javascript">
		$(".title").click(function() {
			$(this).next().toggle();
			//alert($(this).children("ul").style()); //.toggle();

		});
	</script>
<link rel="stylesheet" type="text/css"
	href="__ROOT__/HOME/Tpl/css/jquery.artZoom.css" media="screen" />
<script type="text/javascript"
	src="__ROOT__/HOME/Tpl/js/jquery.artZoom.js"></script>
<script type="text/javascript"
	src="__ROOT__/HOME/Tpl/js/picShow/jquery.js"></script>
<script type="text/javascript"
	src="__ROOT__/HOME/Tpl/js/picShow/jquery.rotate.js"></script>
<script type="text/javascript"
	src="__ROOT__/HOME/Tpl/js/picShow/picShow.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>小组</title>

<style type="text/css">
body,button,input,select,textarea {
	font: 14px/1.125 Arial, Helvetica, sans-serif;
}

a {
	text-decoration: none;
}

.content {
	width: 600px;
}

.WB_content {
	border-bottom: #CF0;
	border-bottom-color: #E6E6E6;
	border-bottom-style: solid;
	border: 1px #E6E6E6 solid thin;
}

.WB_face {
	margin: 5 5 5 5;
	float: left;
	position: relative;
	width: 50px;
}

.W_face_radius {
	display: block;
	height: 50px;
	overflow: hidden;
}

.WB_detail {
	margin-left: 65px;
	padding-top: 5px;
}

.WB_info   .WB_text {
	line-height: 17px;
	padding: 5px;
}

.WB_name {
	font-size: 14px;
	font-weight: bold;
	line-height: 16px;
}

.WB_media_list {
	padding: 0 0 15px;
}

.WB_media_list li {
	display: inline;
	margin-right: 3px;
	margin-top: 3px;
	vertical-align: top;
}

.WB_media_list li a.magic_thumb {
	display: inline-block;
	height: 50px;
	overflow: hidden;
	width: 50px;
}

.WB_media_list li a img {
	
}

.WB_media_list li a .imgicon {
	display: inline-block;
}

.WB_media_list li .loading_gif {
	margin: 0 0 20px -80px;
	vertical-align: text-bottom;
}

.WB_media_list li img {
	cursor: pointer;
	display: inline-block;
	vertical-align: top;
}

.WB_media_expand {
	padding: 10px 20px;
	margin: 5px 0px 15px;
	background-color: #f2f2f2;
}
</style>
</head>
<body>
	<div class="content">
		<?php if(is_array($weibo)): $i = 0; $__LIST__ = $weibo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="WB_content">
			<div class="WB_face">
				<a class="W_face_radius"
					href="http://weibo.com/<?php echo ($vo["user"]["profile_url"]); ?>" title=""><img
					title="<?php echo ($vo["user"]["screen_name"]); ?>" alt=""
					src="<?php echo ($vo["user"]["profile_image_url"]); ?>" height="50" width="50"></a>
			</div>
			<div class="WB_detail">
				<div class="WB_info">
					<a class="WB_name" title="<?php echo ($vo["user"]["screen_name"]); ?>"
						href="http://weibo.com/<?php echo ($vo["user"]["profile_url"]); ?>"
						nick-name="<?php echo ($vo["user"]["screen_name"]); ?>"><?php echo ($vo["user"]["screen_name"]); ?></a>
				</div>
				<div class="WB_text"><?php echo ($vo["text"]); ?></div>
				<div id="pic<?php echo ($i); ?>"></div>
				<script>
				$("#pic<?php echo ($i); ?>").actizPicShow(<?php echo ($vo['picsjson']); ?>);
				</script>
				<!-- 判断是不是不转发 -->
				<?php if(isset($vo["retweeted_status"])): ?><div class="WB_media_expand">
					<div>
						<div class="WB_info"><?php echo ($vo["retweeted_status"]["source"]); ?></div>
						<div class="WB_text"><?php echo ($vo["retweeted_status"]["text"]); ?></div>
						<div id="repic<?php echo ($i); ?>"></div>
						<script>
						$("#repic<?php echo ($i); ?>").actizPicShow(<?php echo ($vo['repicsjson']); ?>);
						</script>
					</div>

				</div><?php endif; ?>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>

</body>
</html>