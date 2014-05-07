<%@ page language="java" pageEncoding="utf-8"%>

<%@ taglib prefix="s" uri="/struts-tags"%>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>收藏共享</title>
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<link href="css/app.css" rel="stylesheet" type="text/css">
		<link href="css/layer_frame.css" rel="stylesheet" type="text/css">
		<link href="css/layer_mini_info.css" rel="stylesheet"
			type="text/css">
		<!-- 引入 jQuery -->
		<script src="../js/jquery.js" type="text/javascript"></script>
		<script src="../js/app.js" type="text/javascript"></script>
		<script src="../js/wb.js" type="text/javascript"></script>

		<script src="../js/bundle.js" charset="UTF-8"></script>
		<script src="../js/hoverCard.js" charset="UTF-8"></script>
		<link rel="stylesheet" type="text/css" href="../css/weiboCard.css">
	</head>
	<body>
	<body>
		<iframe id="sina_anywhere_iframe" style="display: none;"></iframe>
		<div id="app_main">
			<div id="content">
				<!--左侧信息展示区-->
				<div id="cont_left">
					<div id="user">
						<!--头像昵称地区-->
						<div class="basic">
							<div class="avatar">
								<a target="_blank" title="${user.screenName }"
									href=" http://weibo.com/u/${user.id }"> <img
										alt="${user.name }" src="${user.profileImageUrl } +'.jpg'">
								</a>
							</div>
							<div id="userinfo">
								<p class="name">
									<a target="_blank" title="${user.screenName }"
										href="http://weibo.com/u/${user.id }">${user.screenName }
									</a>
								</p>
								<p class="locate">
									${ user.location}
								</p>
							</div>
						</div>
						<!--/头像昵称地区-->
						<!--个人信息-->
						<div class="fans">
							<div class="fansinfo">

								<ul>
									<li>
										<div class="num">
											<a target="_blank"
												href=" http://weibo.com/${user.id  }/follow'">${user.friendsCount
												}</a>
										</div>
										<a target="_blank"
											href=" http://weibo.com/${user.id  }/follow'">关注</a>
									</li>
									<li>
										<div class="num">
											<a target="_blank"
												href=" http://weibo.com/${user.id}/fans">${user.followersCount
												}</a>
										</div>
										<a target="_blank"
											href="http://weibo.com/${user.id  }/fans">粉丝</a>
									</li>
									<li class="no_border">
										<div class="num">
											<a target="_blank"
												href="http://weibo.com/${user.id  }/profile">${user.statusesCount
												}</a>
										</div>
										<a target="_blank"
											href="http://weibo.com/'+${user.id  }+'/profile">微博</a>
									</li>
									<li>
										<div class="num">
											<a target="_blank"
												href=" 'http://weibo.com/'+${user.id  }+'/favourites'">${user.favouritesCount
												}</a>
										</div>
										<a target="_blank"
											href="http://weibo.com/'+${user.id  }+'/favourites">粉丝</a>
									</li>
								</ul>
							</div>
						</div>
						<!--个人信息-->
					</div>

				</div>
			</div>
		</div>


		<s:iterator value="#attr.favors" var="book">
			<tr>
				<td>
					<s:property value="#book.status.user.screenName" />
				</td>

			</tr>
		</s:iterator>

	</body>
</html>

