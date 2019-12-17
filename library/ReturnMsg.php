<?php
namespace yichenthink\utils;

// http返回数组格式化

class ReturnMsg {
	public static $type = 'json';
	/**
	 * 返回成功
	 */
	public static function returnMsg($coder = 200, $message = '', $data = [], $header = []) {

		switch (gettype($coder)) {
		case 'array':
			$code = $coder[0];
			$response_code = $coder[1] ?? 200;
			# code...
			break;
		case 'object':
			$code = $coder['code'];
			$response_code = $coder['status'] ?? 200;
			# code...
			break;

		default:
			$code = $coder;
			$response_code = $code;
			# code...
			break;
		}

		if (empty($message)) {
			// $Send = new Send();
			if (isset(self::$status[$code])) {
				// 根据状态码设置返回信息
				$message = self::$status[$code];
			} else {
				$message = "未知";
			}
		}
		$return['code'] = $code;
		$return['message'] = $message;
		if (is_array($data) || is_object($data)) {
			$return['data'] = $data;
		} else {
			$return['data'] = ['info' => $data];
		}
		http_response_code($response_code); //设置返回头部状态码 一般成功响应返回了数据都是200
		// 发送头部信息
		foreach ($header as $name => $val) {
			if (is_null($val)) {
				header($name);
			} else {
				header($name . ':' . $val);
			}
		}
		switch (self::$type) {
		case 'json':
			echo json_encode($return, JSON_UNESCAPED_UNICODE);
			# code...
			break;

		default:
			// echo "<pre>";
			print_r($return);
			break;
		}
		// echo json_encode($returnData, JSON_UNESCAPED_UNICODE);
		die();
	}
	public static $status = [
		"200" => "成功",
		"204" => "没有新内容",
		"206" => "部分请求处理成功",
		"400" => "失败",
		"500" => "未知错误",
		"404" => "页面不存在",
		"405" => "未授权",
		"40000" => "记录已存在",
		"40001" => "参数错误",
		"40002" => "回跳地址不在预设域下",
		"40003" => "页面发生错误，请稍后重试",
		"40004" => "该授权页面因过度访问暂时被封禁",
		"40005" => "分表路由失败，需设置分表字段内容。",
		"40006" => "文件超过限定尺寸",
		"44000" => "用户名或密码错误",
		"44001" => "TOKEN不合法",
		"44002" => "TOKEN已注销",
		"44003" => "TOKEN已过期",
		"44004" => "TOKEN认证失败",
		"45000" => "小程序不存在",
		"45001" => "无APP操作权限",
		"45002" => "授权异常",
		"46000" => "redis中无值",
		"47000" => "图片格式无效",
		"47001" => "图片上传失败",
		"47002" => "获取二维码失败",
		"47003" => "图片尺寸超过限制",
		"47004" => "修改名称超过限制次数",
		"47005" => "修改头像超过限制次数",
		"47006" => "修改简介超过限制次数",
		"47007" => "修改服务分类超过限制次数",
		"47008" => "图片来源非法",
	];
}
