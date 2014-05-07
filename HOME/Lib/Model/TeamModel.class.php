<?php
class TeamModel extends Model {
// 	protected $_link = array (
// 			'teamuser' => array (
// 					'mapping_type' => MANY_TO_MANY,
// 					'class_name' => 'teamuser',
// 					'mapping_name' => 'teamuser',
// 					'foreign_key' => 'teamid',
// 					'relation_foreign_key'=>'id',
// 					'relation_table'=>'tom_team'
				
// 			) 
// 	);
	// 定义自动验证
	// protected $_validate = array(
	// array('area','require','地址必须'),
	// );
	// // 定义自动完成
	// 在使用数字或者字符串常量时，不要在函数里写死，要多用静态变量代替：胡波波
	protected $_auto = array (
			array (
					'create_time',
					'time',
					Model::MODEL_INSERT,
					'function' 
			) 
	);
}