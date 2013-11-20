<?php
/**
 * <p>优酷视频转无广告版<strong>&lt;yk&gt;http://v.youku.com/v_show/id_...html&lt;/yk&gt;</strong>即可</p>
 * @package 优酷转无广告
 * @author 镜花水月
 * @version 1.0.1
 * @dependence 9.9.2-*
 * @link http://kloli.tk/blog
 */
class YkSwfNoAd implements Typecho_Plugin_Interface{
	/**
	 * 激活插件方法,如果激活失败,直接抛出异常
	 *
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function activate(){
		//离线浏览器都是所见即所得模式
		Typecho_Plugin::factory('Widget_XmlRpc')->fromOfflineEditor = array('YkSwfNoAd', 'toCodeEditor');
		/** 前端输出处理接口 */
		Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('YkSwfNoAd', 'parse');
		Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('YkSwfNoAd', 'parse');
	}
	/**
	 * 禁用插件方法,如果禁用失败,直接抛出异常
	 *
	 * @static
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function deactivate(){

	}
	/**
	 * 获取插件配置面板
	 *
	 * @access public
	 * @param Typecho_Widget_Helper_Form $form 配置面板
	 * @return void
	 */
	public static function config(Typecho_Widget_Helper_Form $form){

	}
	/**
	 * 个人用户的配置面板
	 *
	 * @access public
	 * @param Typecho_Widget_Helper_Form $form
	 * @return void
	 */
	public static function personalConfig(Typecho_Widget_Helper_Form $form){

	}
	/**
	 * 将伪可视化代码转化为可视化代码
	 *
	 * @access public
	 * @param string $content 需要处理的内容
	 * @return string
	 */
	public static function toVisualEditor($content){
		$url = preg_replace("/<(yknad)>(.*?)<\/\\1>/is", "\\2", $content);
		$ykurl = parse_url($url);
		$ykid = explode('id_', str_replace('.html', '', $ykurl['path']));
		$ykid = $ykid[1];
		return preg_replace("/<(yknad)>(.*?)<\/\\1>/is", "<embed src=\"http://lab.yukimax.com/yk-".$ykid.".swf\" allowFullScreen=\"true\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\"></embed>", $content);
	}
	/**
	 * 将可视化代码转化为伪可视化代码
	 *
	 * @access public
	 * @param string $content 需要处理的内容
	 * @return string
	 */
	public static function toCodeEditor($content){
		// return preg_replace("/<(object)[^>]*data=\"{$swfUrl}\?ykid\=([^\">]+)\"[^>]*>(.*?)<\/\\1>/is", "<mp3>\\2</mp3>", $content);
	}
	/**
	 * 插件实现方法
	 *
	 * @access public
	 * @return void
	 */
	public static function parse($text, $widget, $lastResult){
		$text = empty($lastResult) ? $text : $lastResult;
		if($widget instanceof Widget_Archive){
			$text = preg_replace("/<(yk)>id(.*?)<\/\\1>/is", "<embed src=\"http://lab.yukimax.com/yk-\\2.swf\" allowFullScreen=\"true\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\"></embed>", $text);
		}
		return $text;
	}
}
