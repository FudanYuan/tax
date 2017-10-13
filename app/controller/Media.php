<?php 
/**
 * 多媒体--控制器
 * author：yzs
 * create：2017.4.8
 */
namespace app\controller;

class Media extends Common{
	/**
	 * 上传多媒体
	 */
	public function upload(){
		D('Upload')->upload();
	}
	/**
	 * 获取图片
	 */
	public function getimg(){
		$name = input('get.name');
		return file_get_contents(ADDON_PATH.'Medias/'.$name);
	}
	public function ueditor(){
		require ADDON_PATH.'Sdk/ueditor/controller.php';
	}
}
?>