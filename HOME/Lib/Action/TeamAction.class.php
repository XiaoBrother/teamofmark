<?php
require_once 'HOME/Lib/Common/Sina.php';
require_once 'HOME/Lib/Config/snsconst.php';
// 本类由系统自动生成，仅供测试用途
class TeamAction extends BaseAction {
	private $sina;
	public function __construct() {
		parent::__construct ();

		$app_key = SnsConst::SINA_APP_KEY; // 新浪微博应用App Key
		$app_secret = SnsConst::SINA_APP_SECRET; // 新浪微博应用App Secret
		$callback_url = SnsConst::SINA_CALLBACK_URL; // 回调网址，请根据自己的实际情况修改// 回调网址，请根据自己的实际情况修改
		$token = session ( AppConfig::$SESSION_TOKEN );
		$this->sina = new SaeTClientV2 ( $app_key, $app_secret, $token );
	
	}
	public function team($tid = 0) {
		$Model = new Model ();
		$teamdata = $Model->table ( 'tom_team t' )->where ( 't.id=' . $tid )->select ();
		$taglist = split ( ',', $teamdata ['0'] ['tag'] );
		$tagasql = "";
		foreach ( $taglist as $k => $v ) {
			if (isset ( $v ) && $v != "") {
				if ($k == 0) {
					$tagasql = $tagasql . 'tf.tags_tag="' . $v . '" ';
				} else {
					$tagasql = $tagasql . ' or tf.tags_tag="' . $v . '" ';
				}
			}
		}

		$data = $Model->table ( 'tom_team t,tom_favorites tf' )->where ( $tagasql . ' and t.id=' . $tid )->select ();
		/*
		 * $ids = ""; foreach ( $data as $k => $v ) { $ids = $ids . $v ['weibo_id'] . ","; }
		 */
		$weiboarray = array ();
		foreach ( $data as $k => $v ) {
			$weibo = $this->sina->show_status ( $v ['weibo_id'] );
			$arr = array();
			$pdata=$weibo['pic_urls'];
		    //判断是转发
			if(!empty($weibo["retweeted_status"]))	$pdata=$weibo["retweeted_status"]['pic_urls'];
			for ($i = 0; $i < count($pdata); $i++) {
			$data	= array ('id'=>$i,'img'=>$pdata[$i]['thumbnail_pic'],'middleimg'=> str_replace("thumbnail","bmiddle",$pdata[$i]['thumbnail_pic']),'bigimg'=>str_replace("thumbnail","large",$pdata[$i]['thumbnail_pic']));
			array_push($arr, $data);
			}
			$pic = array ('data'=>$arr);
			empty($weibo["retweeted_status"])?$weibo['picsjson']=json_encode($pic):$weibo['repicsjson']=json_encode($pic);
			array_push($weiboarray, $weibo);
		}
		// $weibo= $c->show_batch($ids);
		$this->weibo = $weiboarray;
		$this->display ();
	}
	/**
	 * 新建小组
	 */
	public function teamdetail($tid = 0) {
		$team = D ( 'Team' );
		$token = session ( 'token' );
		if ($team->create ()) {
			// 新增小组
			$id = $team->id;
			$team->owner = session ( "uid" );
			$team->create_time = time ();
			// 获取选择的tags
			$area_arr = $_POST ['tags'];
			$area_str = "";
			foreach ( $area_arr as $k => $v ) {
				$area_str = $area_str . $v . ",";
			}
			$team->tag = $area_str;
			//id<0 新增
			if ($id < 0) {
				$data = $team->add ();
				$this->addUser4Team ( $data );
			}//修改小组
			elseif ($id > 0) {
				$data = $team->save ();
				$this->addUser4Team ( $id );
			}
		} elseif (isset ( $tid ) && $tid != 0) {
			// 查看小组
			$teamdata = $team->find ( $tid );
			// 小组标签
			$teamtag = $teamdata ['tag'];
			$taglist = split ( ",", $teamtag );
			$this->usertags = $taglist;
			// 小组用户
			$teamuser = D ( 'Teamuser' );
			$tslist = $teamuser->where ( 'teamid=' . $tid )->select ();
			$tslistdata = "";
			foreach ( $tslist as $v ) {
				if (isset ( $v ) && $v != "") {
					$tslistdata = $tslistdata . $v ['userid'] . ",";
				}
			}
			// 获取微博用户所有的标签
			$tags = $this->c->favorites_tags ();
			$this->tags = $tags ['tags'];
			$this->teamdata = $teamdata;
			$this->tslistdata = $tslistdata;
			$this->display ( 'teamdetail' );
		}

		else {

			// 获取用户的标签
			$tags = $this->sina->favorites_tags ();
			$this->tags = $tags ['tags'];
			$this->teamdata->$team;
			$this->display ( 'teamdetail' );
		}
	}
	/**
	 * @对象
	 */
	public function complete($adduser = '') {
		header ( 'Content-Type:application/json; charset=UTF-8' );
		$list = split ( '@', $adduser );
		$friend = $this->c->search_at_users ( end ( $list ) );
		$data = array ();
		foreach ( $friend as $k => $v ) {
			array_push ( $data, $v ['nickname'] );
		}
		$this->success ( $data );
	}
	/**
	 * 新增 用户显示
	 */
	public function addUser($adduser = '') {
		$list = split ( '@', $adduser );
		$data = array ();
		foreach ( $list as $v ) {
			if (isset ( $v ) && $v != "") {
				$userdata = $this->c->show_user_by_name ( trim ( $v ) );
				array_push ( $data, $userdata );
			}
		}
		$this->success ( $data );
	}
	/**
	 * 新增 用户显示BY ID
	 */
	public function addUserById($tslistdata) {
		$list = split ( ',', $tslistdata );
		$data = array ();
		foreach ( $list as $v ) {
			if (isset ( $v ) && $v != "") {
				$userdata = $this->c->show_user_by_id ( trim ( $v ) );
				array_push ( $data, $userdata );
			}
		}
		$this->success ( $data );
	}

	/**
	 * 添加team的用户
	 */
	public function addUser4Team($data) {
		$uid_arr = $_POST ['uid'];
		$dataList = array ();
		$i = 0;
		foreach ( $uid_arr as $k => $v ) {
			$dataList [$i] ['teamid'] = $data;
			$dataList [$i] ['userid'] = $v;
			$dataList [$i] ['status'] = 0;
			$i ++;
		}
		$teamuser = D ( 'Teamuser' );
		$teamuser->create ( $dataList [$i] );
		$teamuser->addall ( $dataList, $options = array (), $replace = true );
	}
	/* (non-PHPdoc)
	 * @see BaseAction::registeUncheckedMethod()
	 */
	public function registeUncheckedMethod() {
		// TODO Auto-generated method stub
		
	}

}