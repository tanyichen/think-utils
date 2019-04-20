<?php
namespace yichenthink\utils;
use think\facade\Config;
use think\facade\Session;

class MakeId {
	public static $serverId = 10; //服务器id数字;
	public static $error = ''; //失败信息
	public static function getError() {
		return self::$error;
	}
	/**
	 * 随机数字
	 */
	public function makeCode($num = 6) {
		$max = pow(10, $num) - 1;
		$min = pow(10, $num - 1);
		return rand($min, $max);
	}
	/**
	 * 生成token;
	 */
	public static function Token() {
		return self::Str();
	}
	/**
	 * 生成用户id;
	 */
	public static function User() {
		return self::serverId() . self::Number();
	}
	/**
	 * 生成唯一ID(28位) 2位服务器id编号+26位唯一编号;
	 */
	public static function Number() {
		$code = time() . rand(1000, 4);

		return self::serverId() . $code;
	}
	public static function serverId() {
		if (self::$serverId) {
			return self::$serverId;
		} elseif (Config::get('app.')["host_id"]) {
			return Config::get('app.')["host_id"];
		} else {
			return '';
		}
	}
	/**
	 * 生成唯一ID(18位) 由redis;
	 */
	public static function Str() {
		return self::serverId() . md5(uniqid() . self::Number());
	}
// 	1、md5(time() . mt_rand(1,1000000));

// 　　这种方法有一定的概率会出现重复

// 2、php内置函数uniqid()
}
