<?php
require_once 'HOME/Lib/Config/AppConfig.php';
require_once ('HOME/Lib/Common/Sina.php');
require_once 'HOME/Lib/Config/snsconst.php';
class IndexAction extends Action {
	public function index() {
		$this->display ();
	}
	/**
	 * 生成对应的oauth地址
	 */
	public function snslogin() {
		$app_key = SnsConst::SINA_APP_KEY; // 新浪微博应用App Key
		$app_secret = SnsConst::SINA_APP_SECRET; // 新浪微博应用App Secret
		$callback_url = SnsConst::SINA_CALLBACK_URL; // 回调网址，请根据自己的实际情况修改
		$sina = new SaeTOAuthV2 ( $app_key, $app_secret );
		$sina_url = $sina->getAuthorizeURL ( $callback_url ); // 生成登录链接，部分平台需要权限，格式请参考各平台api文档
		$type = $this->_param ( 'type' );
		$url = '';
		
		if ('sina' == $type) {
			$url = $sina_url . "&type=sina";
		}
		
		echo '<SCRIPT LANGUAGE="javascript">';
		echo "location.href='$url'";
		echo '</SCRIPT>';
	}
	/**
	 * 新浪回调函数
	 */
	public function callback() {
		$app_key = SnsConst::SINA_APP_KEY; // 新浪微博应用App Key
		$app_secret = SnsConst::SINA_APP_SECRET; // 新浪微博应用App Secret
		$callback_url = SnsConst::SINA_CALLBACK_URL; // 回调网址，请根据自己的实际情况修改// 回调网址，请根据自己的实际情况修改
		
		$o = new SaeTOAuthV2 ( $app_key, $app_secret );
		if (isset ( $_GET ['code'] ) && $_GET ['code'] != '') {
			$keys = array ();
			$keys ['code'] = $_REQUEST ['code'];
			$keys ['redirect_uri'] = $callback_url;
			try {
				$token = $o->getAccessToken ( 'code', $keys );
			} catch ( OAuthException $e ) {
			}
			$c = new SaeTClientV2 ( $app_key, $app_secret, $token ['access_token'] );
			
			session ( AppConfig::$SESSION_TOKEN, $token ['access_token'] );
			$ms = $c->home_timeline (); // done
			$f = $c->get_favorites ();
			
			$uid_get = $c->get_uid ();
			$uid = $uid_get ['uid'];
			$type = 'sina';
			session ( AppConfig::$SESSION_UID, $uid );
			// 获取用户基本信息
			$user = $c->show_user_by_id ( $uid );
			$this->user = $user;
			
			session ( AppConfig::$SESSION_USER, $user );
			// 保存登录用户的收藏
			$fid = $c->get_favorites_ids ();
			$dataList = array ();
			$i = 0;
			foreach ( $fid ['favorites'] as $k => $v ) {
				
				$dataList [$i] ['weibo_id'] = $v ['status'];
				$v2 = $v ['tags'] ['0'];
				
				$dataList [$i] ['tags_id'] = $v2 ['id'];
				$dataList [$i] ['tags_tag'] = $v2 ['tag'];
				$dataList [$i] ['tags_count'] = $v2 ['count'];
				$dataList [$i] ['favorited_time'] = strtotime ( $v ['favorited_time'] );
				$dataList [$i] ['userid'] = $uid;
				// $favority = D ( 'Favorites' );
				// $favority->create ( $dataList [$i] );
				// $favority->add ( $dataList [$i] ,$options=array(),$replace=true);
				$i ++;
			}
			$favority = D ( 'Favorites' );
			$favority->create ( $dataList );
			$favority->addAll ( $dataList, $options = array (), $replace = true );
			// $user= $c->show_user_by_id($uid);
			// $this->data = $f ['favorites'];
			// $this->user = $user;
			// 显示用户小组
			
			echo '<SCRIPT LANGUAGE="javascript">';
			echo "location.href='http://localhost/teamofmark/index.php/Index/main'";
			echo '</SCRIPT>';
			
			/*
			 * //储存用户 $user = D ( 'User' ); $this->data = $f ['favorites']; // 把查询条件传入查询方法 $data = $user->where ( 'sina=' . $uid )->select (); if ($data) { $this->display ( 'main' ); } else { $data = array (); $data ['sina'] = $uid; $user->create ( $data ); $result = $user->add (); $this->display ( 'main' ); }
			 */
		}
	}
	public function main() {
		$this->user = session(AppConfig::$SESSION_USER);
		$team = D ( 'Team' );
		$this->team ( session(AppConfig::$SESSION_UID) );
		
		$this->display ( 'main' );
	}
	public function team($uid) {
		// $sina = session ( 'token' );
		// $c = new SaeTClientV2 ( $app_key, $app_secret, $token ['access_token'] );
		// $sina ->get_uid();
		$Model = new Model ();
		// $data =$Model->table('tom_team t,tom_teamuser ts')
		// ->where(' t.id=ts.teamid')
		// ->select();
		// echo $Model->getLastSql();
		// dump ( $data );
		// $this->asd=$data;
		// 我创建的小组
		$myteam = $Model->query ( $this->teamSQL ( "and t.owner=" . $uid ) );
		$this->myteam = $myteam;
		
		// 我加入的小组
		$team = $Model->query ( $this->teamSQL ( "and status=1 and t.owner<>" . $uid  ) );
		$this->team = $team;
		
		// 邀请的小组
		$jointeam = $Model->query ( $this->teamSQL ( "and status=0 and t.owner<>" . $uid ) );
		$this->jointeam = $jointeam;
		// $this->display ();
	}
	public function teamSQL($sqlcount) {
		return $sql = " SELECT * ,count(userid) num FROM tom_team t,tom_teamuser ts WHERE ( t.id=ts.teamid " . $sqlcount . " )  group by  ts.teamid";
	}
}