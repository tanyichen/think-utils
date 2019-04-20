<?php
namespace yichenthink\utils;

/**
 * 加密解密处理
 */
class Encrypt {

	/**
	 * 默认生成密文
	 * @return flem_item_text
	 */
	static function make($str) {
		return self::make32($str);
	}
	// 生成32位密文
	static function make32($str) {
		return md5(md5($str));
	}

}
