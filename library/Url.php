<?php
namespace yichenthink\utils;

/**
 * url处理
 */
class Url {

	/**
	 * 替换掉Url的斜杠为标准字符串 并且转成小写
	 * @url =flem/item/text
	 * @return flem_item_text
	 */
	static function replaceStr($url = '', $str = ['/' => '.']) {
		foreach ($str as $key => $value) {
			$url = strtolower(str_replace($key, $value, $url));
		}
		return $url;
	}

}
