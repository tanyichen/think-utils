<?php
namespace yichenthink\utils;

/**
 * url处理
 */
class SqlHandle {
/**
 * 读取sql文件为数组
 * @param $sqlFile sql 文件路径
 * @param string $prefix 添加表前缀
 * @return array|bool
 */
	public function get_sql_array($sqlFile = '', $prefix = '') {
		if (!file_exists($sqlFile)) {
			return false;
		};
		$str = file_get_contents($sqlFile);
		// 去除#开头的行 或者/* */ 或者//
		$str = preg_replace('/#(.*)|\/\/|(\/\*(.|\s)*?\*\/)|(\n)/', '', $str);
		if (!empty($prefix)) {
			$str = preg_replace_callback("/(REFERENCES|CONSTRAINT|EXISTS|INSERT\\s+?INTO|UPDATE|DELETE\\s+?FROM|SELECT.+?FROM|LEFT\\s+JOIN|TABLE\\s|JOIN|LEFT)([\\s]|[\\s`])+?(\\w+)([\\s`]|[\\s(])+?/is",
				function ($matches) use ($prefix) {
					// var_dump($matches);
					return str_replace($matches[3], $prefix . $matches[3], $matches[0]);
				},
				$str);
		}
		$list = explode(';', trim($str));
		foreach ($list as $key => $val) {
			if (empty($val)) {
				unset($list[$key]);
			} else {
				$list[$key] .= ';';
			}
		}
		return array_values($list);
	}

}
