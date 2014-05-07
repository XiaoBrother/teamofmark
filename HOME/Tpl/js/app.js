//应用JS加载
$(function(){
	var cuid		= $CONFIG.cuid;		//当前用户UID
	var oauthurl	= $CONFIG.oauthUrl;
	var token		= $CONFIG.token;
	var appurl		= $CONFIG.appurl;
	var wb_key		= $CONFIG.wb_key;
	var canvas		= $CONFIG.canvas;
	var filter		= 0; //设置当前搜索类型
	var page		= 2; //延续数据从第二页开始
	var pageMax		= $CONFIG.pageMax;//每页最大数


	//解决IE8下字体高度问题
	if($.browser.msie && parseInt($.browser.version) <= 8 ){
		$("#filter p").css("padding-top","1px");
		$(".operate a").css("padding-top","1px");
		//$(".app_score").css("margin-top","0");
	}

	//加载check点击功能
	$(".check").click(function(){
		$(this).toggleClass("ED");
		//设置value值
		if($(this).attr("value") == 0){
			$(this).attr("value",1);
		}else{
			$(this).attr("value",0);
		}
	});

	//加载名片
	WB2.anyWhere(function(W){
		W.widget.hoverCard({
			id: "recuserlist",
			tag: "a",
			search: true
		});
		W.widget.hoverCard({
			id: "mbloglist",
			tag: "a",
			search: true
		});
		W.widget.hoverCard({
			id: "footer",
			tag: "a",
			search: true
		}); 
	});
	
	//全部
	$("#all").click(function(){
		filterClick(0);
	});

	//原创
	$("#ori").click(function(){
		filterClick(1);
	});

	//图片
	$("#pic").click(function(){
		filterClick(2);
	});

	//视频
	$("#vid").click(function(){
		filterClick(3);
	});

	//音乐
	$("#mus").click(function(){
		filterClick(4);
	});

	/*
	 * 根据点击的类型获取相关微博数据
	 *
	 * filter	//当前类别
	 *
	 */
	function filterClick(flt){
		if(filter != flt){
			filter = flt;				//设置当前搜索类型
			page = 2;					//初始化延续数据页码
			$("#mbloglist").empty();	//移除DOM中数据
			$(".page").empty();			//移除翻页中数据
			appLoading("show");			//加载提示
			$.getJSON(appurl+"/index.php/Ajax/getMblogs",{cuid:cuid, token:token, filter:filter, page:1, pagesize:100},function(result){
				if(result.status == 100000){
					appLoading("hide");//移除加载提示
					$("#mbloglist").append(result.data.html);
					$("#cnum").text(result.data.cnum);
					$("#total").text(result.data.totel);
					if(result.data.totel > pageMax){
						$.getJSON(appurl+"/index.php/Ajax/getSelect",{totel:result.data.totel, pageMax:pageMax},function(result){
							if(result.status == 100000){
								$(".page").append(result.data);
								//翻页
								$("#page").change(function(){
									var pageNum = $(this).attr("value");
									if(pageNum >= pageMax){
										pageNum = pageNum/pageMax+1;
									}else{
										pageNum = 1;
									}

									$("#mbloglist").empty(); //移除DOM中数据
									appLoading("show");		 //加载提示
									$.getJSON(appurl+"/index.php/Ajax/getMblogs",{cuid:cuid, token:token, filter:filter, page:pageNum, pagesize:pageMax},function(result){
										if(result.status == 100000){
											appLoading("hide");//移除加载提示
											$("#mbloglist").append(result.data.html);
											$("#cnum").text(result.data.cnum);
											$("#total").text(result.data.totel);
										}
										//加载名片
										WB2.anyWhere(function(W){
											W.widget.hoverCard({
												id: "mbloglist",
												tag: "a",
												search: true
											});
										});

										//加载check点击功能
										$("#mbloglist .check").click(function(){
											$(this).toggleClass("ED");
											//设置value值
											if($(this).attr("value") == 0){
												$(this).attr("value",1);
											}else{
												$(this).attr("value",0);
											}
										});

									});
									
								});
							}
						});
					}
				}
				//加载名片
				WB2.anyWhere(function(W){
					W.widget.hoverCard({
						id: "mbloglist",
						tag: "a",
						search: true
					});
				});

				//加载check点击功能
				$("#mbloglist .check").click(function(){
					$(this).toggleClass("ED");
					//设置value值
					if($(this).attr("value") == 0){
						$(this).attr("value",1);
					}else{
						$(this).attr("value",0);
					}
				});

			});
		}
	}

	//类别展示微博按钮切换
	$(".radio").click(function(){
		var id = $(this).attr("id");
		$(this).addClass("ED").attr("value",1);
		$(".radio:not(#"+id+")").removeClass("ED").attr("value",0);
	});
	
	//翻页
	$("#page").change(function(){
		var pageNum = $(this).attr("value");
		if(pageNum >= pageMax){
			pageNum = pageNum/pageMax+1;
		}else{
			pageNum = 1;
		}

		$("#mbloglist").empty(); //移除DOM中数据
		appLoading("show");		 //加载提示
		$.getJSON(appurl+"/index.php/Ajax/getMblogs",{cuid:cuid, token:token, filter:filter, page:pageNum, pagesize:pageMax},function(result){
			if(result.status == 100000){
				appLoading("hide");//移除加载提示
				$("#mbloglist").append(result.data.html);
				$("#cnum").text(result.data.cnum);
				$("#total").text(result.data.totel);
			}
			//加载名片
			WB2.anyWhere(function(W){
				W.widget.hoverCard({
					id: "mbloglist",
					tag: "a",
					search: true
				});
			});

			//加载check点击功能
			$("#mbloglist .check").click(function(){
				$(this).toggleClass("ED");
				//设置value值
				if($(this).attr("value") == 0){
					$(this).attr("value",1);
				}else{
					$(this).attr("value",0);
				}
			});

		});
		
	});

	//全选
	$("#checkAll").click(function(){
		$("#checkOpp").removeClass("ED");//移除反选样式
		if($(this).attr("value") == 1){
			$(this).addClass("ED");
			$("#mbloglist .check").addClass("ED").attr("value",1);
		}else{
			$(this).removeClass("ED");
			$("#mbloglist .check").removeClass("ED").attr("value",0);
		}
	});

	//反选
	$("#checkOpp").click(function(){
		$("#checkAll").removeClass("ED");//移除全选样式
		$("#mbloglist .check").toggleClass("ED").each(function(){
			if($(this).attr("value") == 0){
				$(this).attr("value",1);
			}else{
				$(this).attr("value",0);
			}
		});
		
	});

	//删除微博
	$("#delMblog").click(function(){
		var length = $("#mbloglist .ED").length;
		if(length == 0){
			$('#appMINIConfirm').remove();
			appMINIConfirm('error','请先选择微博');
			setTimeout("$('#appMINIConfirm').remove()", 1000);//停顿1秒后移动MINI提示
			return false;
		}
		overlay('show'); //屏蔽操作
		appConfirm(length);	//弹出提示框
		
		//删除提示框-确定按钮
		$("#del").click(function(){
			$("#appConfirm").remove();//移除提示框
			$("#mbloglist .ED").each(function(){
				//获取MID
				var mid = $(this).attr("mid");
				
				//调用内部接口删除微博
				/*
				$.getJSON(appurl+"/index.php/Ajax/delMblogByMid",{token:token, mid:mid},function(result){
					if(result.status == 100000) $(".listinfo:[mid="+mid+"]").remove(); //先移除DOM中数据
				});
				*/
				
				//调用JS-SDK删除微博-V2
				WB2.anyWhere(function(W){
					// 取消关注
					W.parseCMD("/statuses/destroy.json", function(sResult, bStatus){
						if(bStatus == true) {
							if(sResult.id) $(".listinfo:[mid="+sResult.id+"]").remove(); //先移除DOM中数据
						}
					},{
						id : mid
					},{
						method: 'post'
					});
				});
				
			});

			//减掉总数和当前数目
			$("#cnum").text(parseInt($("#cnum").text()) - length);
			$("#total").text(parseInt($("#total").text()) - length);
			
			appMINIConfirm('succ','删除成功');
			setTimeout("$('#appMINIConfirm').remove()", 2000);//停顿2秒后移动MINI提示
			overlay('hide'); //取消屏蔽
		});

		//删除提示框-关闭按钮
		$("#cel").click(function(){
			//移除提示框
			$("#appConfirm").remove();//移除提示框
			overlay('hide'); //取消屏蔽
		});
	});

	//关注
	$(".W_addbtn").click(function(){
		$.getJSON(appurl+"/index.php/Ajax/follow",{token:token},function(re){
			if(re.status == '100000') $(".W_addbtn").attr("class", "W_addbtn_es");
		});	
	});

	//分享到微博
	$("#share").click(function(){
		WB2.anyWhere(function(W){
			W.widget.publish();
		});
		setTimeout("$('.WB_textarea').text('#批量管理微博# 分类查询微博，一键批量删除！[给力] http://apps.weibo.com/aiweibo')",1000);
	});
});

//Loading气泡HTML
function appLoading(status){
	// IE6 Fix
	var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
	switch(status) {
		case 'show':
			appLoading('hide');
			$("BODY").append(
				'<div id="loading" class="layer_pop" style="width:185px; position:'+pos+'; top:275px; left:388px;">' +
				  '<span>正在加载，请稍后...</span>' +
				'</div>'
			);
		break;
		case 'hide':
			$("#loading").remove();
		break;
	}
}

//删除提示框HTML
function appConfirm(num){
	// IE6 Fix
	var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
	$("BODY").append(
		'<div id="appConfirm" class="W_layer" style="position:'+pos+'; top:230px; left:380px; z-index:99999;">' +
			'<div class="bg">' +
				'<table border="0" cellspacing="0" cellpadding="0">' +
						'<tr>' +
							'<td>' +
								'<div class="content layer_mini_info">' +
									'<p class="clearfix"><span class="icon_del"></span>确认要删除这 <span class="delnum">'+ num +'</span> 条微博吗？</p>' +
									'<p class="btn"><a id="del" href="javascript:void(0);" class="W_btn_b"><span>确定</span></a><a id="cel" href="javascript:void(0);" class="W_btn_a"><span>取消</span></a></p>' +
								'</div>' +
							'</td>' +
						'</tr>' +
				'</table>' +
			'</div>' +
		'</div>'
	);
}

//MINI提示框HTML
function appMINIConfirm(type, msg){
	if( type == null ) var miniClass = 'icon_warn';
	if( msg == null ) var msg = '参数错误';
	switch(type) {
		case 'succ':
			var miniClass = 'icon_succ';
		break;
		case 'error':
			var miniClass = 'icon_error';
		break;
		case 'warn':
			var miniClass = 'icon_warn';
		break;
	}
	// IE6 Fix
	var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
	$("BODY").append(
		'<div id="appMINIConfirm" class="W_layer" style=" position:'+pos+'; top:260px; left:420px;">' +
			'<div class="bg">' +
				'<table border="0" cellspacing="0" cellpadding="0">' +
						'<tr>' +
							'<td>' +
								'<div class="content layer_mini_info">' +
									'<p class="clearfix"><span class="'+ miniClass +'"></span>'+ msg +'</p>' +
								'</div>' +
							'</td>' +
						'</tr>' +
				'</table>' +
			'</div>' +
		'</div>'
	);
}

//屏蔽操作
function overlay(status) {
	switch( status ) {
		case 'show':
			overlay('hide');
			$("BODY").append('<div id="popup_overlay"></div>');
			$("#popup_overlay").css({
				position: 'absolute',
				zIndex: 99998,
				top: '0px',
				left: '0px',
				width: '100%',
				height: $(document).height(),
				background: '#000000',
				opacity: 0.1
			});
		break;
		case 'hide':
			$("#popup_overlay").remove();
		break;
	}
}