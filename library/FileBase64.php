<?php
namespace yichenthink\utils;
use think\facade\App;

/**
 * FileBase64处理
 */
class FileBase64 {
	public $isBase64 = true; //是原始文件或base64流类型
	public $dirname = ''; //存取位置
	public $rootPath = null; //上传根路径不含图片位置
	public $dir = null; //存取路径 不含图片
	public $filename = null; //资源名字
	public $base64 = null; //base64完整流
	public $base64Prefix = null; //base64前缀
	public $baseFile = null; //文件绝对路径含文件名
	public $url = null; //文件存储位置含文件名
	public $local = true; //是否本地资源路径存取
	public $suffix = null; //文件.后边的后缀名
	public $contentType = null; //资源类型全称
	public $type = null; //资源类型
	public $size = null; //文件大小

	// 匹配base64类型后缀，base64前缀等；
	public function getBase64Info($base64) {
		if (strpos($base64, 'base64') !== false) {
			//匹配出图片的后缀
			if (preg_match('/^data:((\w+)\/(\w+));base64,/', $base64, $base64Info)) {
				try {
					$this->isBase64 = true;
					$this->base64 = $base64;
					$this->suffix = $base64Info[3];
					$this->contentType = $base64Info[1];
					$this->type = $base64Info[2];
					$this->base64Prefix = $base64Info[0];
					$this->file = base64_decode(str_replace($this->base64Prefix, '', $this->base64));
					$this->size = strlen($this->file);
					// $this->base64 = str_replace($base64Info[0], '', $base64);
					return $this; //返回图片信息数组后缀名
				} catch (Exception $e) {
					return false;
				}
			}
		}
		return false;
	}
	// 获取文件后缀基础信息
	public function getFileInfo($file) {
		try {
			$file_name_array = explode(".", $file);
			$this->suffix = $file_name_array[1];
			$this->file = $file;
			$this->isBase64 = false;
			return $this;
		} catch (Exception $e) {
			return false;
		}
	}
	// 存取根地址路径
	public function getRootPath() {
		$this->rootPath = App::getRootPath() . 'public/upload/';
		return $this->rootPath;
	}

	// 准备上传 把base64图片流存入本地path=保存路径，$imgname=图片名不含后缀,返回图片上传信息路径，图片名等
	public function readyUpload($dirname = null, $filename = null) {

		!empty($filename) or $filename = $this->makeFileName();
		empty($dirname) or $this->dirname = $dirname;
		$this->filename = $filename;
		$this->url = $this->dirname . $filename . '.' . $this->suffix;
		// 获取存取地址
		$this->baseFile = $this->getRootPath() . $this->url;
		// 截取目录部分
		$this->dir = substr($this->baseFile, 0, strrpos($this->baseFile, "/"));
		return $this;

	}
	// 开始上传 $local=true是默认本地上传
	public function upload($local = true) {
		// empty($local) or $this->local = $local;
		// 目录如果不存在创建目录
		is_dir($this->dir) or mkdir($this->dir, 0777, true);
		// 存入本地
		if ($local) {
			return $this->uploadLocal();
			// 存入阿里云等外部服务器
		} else {
			return $this->uploadRemote();
		}

	}
	// 上传至远程服务器
	public function uploadRemote() {
		return $this;
	}
	// 上传至本地
	public function uploadLocal() {
		// 是base64流类型
		if ($this->isBase64) {
			if (file_put_contents($this->baseFile, $this->file)) {
				return $this; //保存成功
			}
			// 是file文件类型
		} else {
			if (move_uploaded_file($this->file, $this->baseFile)) {
				return $this; //保存成功
			}
		}
		return false;
	}
	public function destroy($url = null) {
		if (!empty($url) && strpos($url, ".")) {
			$filename = $this->getRootPath() . $url;
			!file_exists($filename) or unlink($filename); //删除旧裁剪图片
		}
	}

	public function savefile($file = null, $dirname = null, $filename = null) {
		if (!empty($file)) {
			!empty($filename) or $filename = $this->makeFileName();
			empty($dirname) or $this->dirname = $dirname;

			$file_name_array = explode(".", $file);

			$url = $this->dirname . $file_name_array[1];
			// 获取存取地址
			$address = $this->getRootPath() . $url;
			// 截取目录部分
			$dir = substr($address, 0, strrpos($address, "/"));
			$this->suffix = $file_name_array[1];
			$this->filename = $filename;
			$this->url = $url;
			// 目录如果不存在创建目录
			is_dir($dir) or mkdir($dir, 0777, true);
			return move_uploaded_file($file, $address); //将临时地址移动到指定地址
		}
	}
	public function makeFileName() {
		return time() . rand(100000, 999999);
	}

}
