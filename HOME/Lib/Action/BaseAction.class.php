<?php
require_once 'HOME/Lib/Config/AppConfig.php';
 abstract class  BaseAction extends  Action{
    private $uncheckMethods=array();
    private $uriarray=array(
    		"/exhibition/villeagereg",
    		"/villeage/villeageselect",
    		"/ufavorite/userfavorite",
    		"/villeage/reginfo",
    		"/villeage/manage",
    		"/variety/manage",
    		"/exhibition/recommendvilleage",
    		"/exhibition/recommendvariety",
    		"/exhibition/aboutus",
    		"/exhibition/appDownload"
     );
 	function _initialize(){
    	$this->uncheckMethods=$this->registeUncheckedMethod();
   		//不想权限验证的方法， 请在registeUncheckedMethod中注册
 		if($this->methodIsChecked()){
	 		if(!$this->checklogin()){
 	 			 //用户未登录
	 			$this->redirect("Index/index");
 	 		}
 		}
   		$this->setUser();
  		$this->setTeam();
 	}
 	/**
 	 * 返回某个方法是否需要进行验证
 	 * @param unknown $methodname
 	 * @return boolean
 	 */
 	private function methodIsChecked(){
 		 if(empty($this->uncheckMethods)) return true;
 		 $method=C('ACTION_NAME')?C('ACTION_NAME'):ACTION_NAME;
  		 foreach ($this->uncheckMethods as $val){
  		 	if(strcmp($val,$method)==0){
   		 		return false;
  		 	}
 		 }
 		 return true;
 	}
 	/**
 	 * 检测用户登录情况
 	 * @return boolean
 	 */
 	private function checklogin(){
 		$user=session(AppConfig::$SESSION_USER);
     	if(!empty($user)){
     			return true;
 		}
 		return false;
 	}
 	
 	public function setTeam() {
 		$uid=session(AppConfig::$SESSION_UID);
 		$Model = new Model ();
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
 
   	/**
   	 * 设置用户
   	 */
   	private function setUser(){
   		$user=session(AppConfig::$SESSION_USER);
   		$user = session(AppConfig::$SESSION_USER);
     	if(!empty($user)){
   			$this->assign("tom_user",$user);
     	}
   	}
 	//返回数组
 	public abstract function registeUncheckedMethod();
 	 
 /**
  * 空操作
  */
  public function _empty(){
     $this->redirect("Index/index");
    }
 	
 }
?>