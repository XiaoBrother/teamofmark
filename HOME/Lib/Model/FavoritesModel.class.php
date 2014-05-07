<?php
class FavoritesModel extends Model {

	// 定义自动验证
// 	protected $_validate    =   array(
// 			array('area','require','地址必须'),
// 	);
// 	// 定义自动完成
//在使用数字或者字符串常量时，不要在函数里写死，要多用静态变量代替：胡波波
 	protected $_auto    =   array(
 			array('create_time','time',Model:: MODEL_BOTH,'function'),
 	);
}