<?php
namespace yichenthink\utils;

/**
 * text处理
 */
class Text {

	/**
	 * 去除PHP代码注释
	 * @param string $content 代码内容
	 * @return string 去除注释之后的内容
	 */
	public function removeComment($content) {
		// 去除#开头的行 或者/* */ 或者//开头
		return preg_replace('/#(.*)|\/\/|(\/\*(.|\s)*?\*\/)|(\n)/', '', $content);
	}

}
