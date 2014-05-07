<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

defined('THINK_PATH') or exit();
/**
 * 系统行为扩展：定位模板文件
 * @category   Think
 * @package  Think
 * @subpackage  Behavior
 * @author   liu21st <liu21st@gmail.com>
 */
class LocationTemplateBehavior extends Behavior {
    // 行为扩展的执行入口必须是run
    public function run(&$templateFile){
        // 自动定位模板文件
        if(!file_exists_case($templateFile))
            $templateFile   = $this->parseTemplateFile($templateFile);
    }

    /**
     *  * 修改：胡波波
     * 为了action目录下能在分目录，使用“_”连接目录和Action，在这里进行分解,
     * 在这里修改视图的跳转目录
     * 自动定位模板文件
     * @access private
     * @param string $templateFile 文件名
     * @return string
     */
    private function parseTemplateFile($templateFile) {
    	
        if(''==$templateFile) {
            // 如果模板文件名为空 按照默认规则定位
            $templateFile = C('TEMPLATE_NAME');
            $templateFile=str_replace("_","/",$templateFile);//修改1,将_替换为/ ,如：System_User/index.html=>System/User/index.html
            //echo "templateFile:".$templateFile;
        }elseif(false === strpos($templateFile,C('TMPL_TEMPLATE_SUFFIX'))){
            // 解析规则为 模板主题:模块:操作 不支持 跨项目和跨分组调用
            $path   =  explode(':',$templateFile);
            $action = array_pop($path);
            $module = !empty($path)?array_pop($path):MODULE_NAME;
            if(!empty($path)) {// 设置模板主题
                $path = dirname(THEME_PATH).'/'.array_pop($path).'/';
            }else{
                $path = THEME_PATH;
            }
            $action=$module.C('TMPL_FILE_DEPR').$action;////修改3,将_替换为/ ,如：System_User/index.html=>System/User/index.html
            $action=str_replace("_","/",$action);
            $templateFile  =  $path.$action.C('TMPL_TEMPLATE_SUFFIX');
            //$templateFile  =  $path.$module.C('TMPL_FILE_DEPR').$action.C('TMPL_TEMPLATE_SUFFIX');
        }
        if(!file_exists_case($templateFile))
            throw_exception(L('_TEMPLATE_NOT_EXIST_').'['.$templateFile.']');
        return $templateFile;
    }
}