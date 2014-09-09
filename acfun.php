<?php
/**
 * <p>AC娘转换(2014/09/04/10/18-Ver)</p>
 * @package AC娘转换
 * @author 镜花水月
 * @version 0.0.4 beta
 * @dependence 9.9.2-*
 * @link http://kloli.tk
 */
class acfun implements Typecho_Plugin_Interface{
	/**
	 * 激活插件方法,如果激活失败,直接抛出异常
	 *
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function activate(){
		/* 前端输出处理接口 */
		Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('acfun', 'parse');
		Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('acfun', 'parse');
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
	 * acfun抓取vid
	 * @access public
	 * @param file_get_contents $url
	 * @return $vid
	 *
	 */
	public static function getvid($path){
		$url = 'http://www.acfun.tv/v/ac'.$path;
		$file = file_get_contents($url);
		preg_match_all("/data-vid=\"([\d]+)\"/is", $file, $out);
		return $out[1][0];
	}
	/**
	 * acfun播放器
	 * @access public
	 * @param getvid $aid
	 * @return $aid
	 */
	public static function parse($text, $widget, $lastResult){
		$text = empty($lastResult) ? $text : $lastResult;
		if($widget instanceof Widget_Archive){
			/*preg_match_all('/<a[^>]*href=\"http\:\/\/www\.acfun\.(tv|com)\/[^>]*\"[^>]*>http\:\/\/[^>]*\/v\/ac([\d]+_[\d]+|[\d]+)<\/a>/is', $text, $aid);
			for($i = 0; $i < count($aid[2]); $i++){
				$vid = self::getvid($aid[2][$i]);
				$text = str_replace($aid[0][$i], '<iframe style="width:100%;height:400px;" src="https://ssl.acfun.tv/block-player-homura.html#vid='.$vid.';from=http://www.acfun.tv;postMessage=1;autoplay=0;hint=A娘弹幕视频" id="ACFlashPlayer-re" frameborder="0"></iframe>', $text);
			}*/
			$text = preg_replace('/<a[^>]*href=\"http\:\/\/www\.acfun\.(tv|com)\/[^>]*\"[^>]*>http\:\/\/[^>]*\/v\/ac([\d]+_[\d]+|[\d]+)<\/a>/is', '<object type="application/x-shockwave-flash" data="http://static.acfun.mm111.net/dotnet/20130418/player/ACFlashPlayer.out.swf" width="100%" height="400"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="seamlesstabbing" value="true"><param name="wmode" value="direct"><param name="allowFullscreenInteractive" value="true"><param name="flashvars" value="type=page&url=http://www.acfun.tv/v/ac$1"></object>', $text);
		}
		return $text;
	}
}
