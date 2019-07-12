<?php
namespace yichenthink\utils;

/**
 * 时间处理插件
 */
class Time {
	static public function is_timestamp($timestamp) {

		if (strtotime(date('M-d-Y H:i:s', $timestamp)) === (int) $timestamp) {
			return $timestamp;
		} else {
			return false;
		}

	}

}
