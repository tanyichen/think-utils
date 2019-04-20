<?php
namespace yichenthink\utils;

/**
 * url处理
 */
class File {
	// 把数组写入文件
	function set_data($array, $file = "./TxtDabase/data.json") {
		if (is_array($array)) {
			I($array); //过滤数组=thinkphp input()
			$txt_file = $file; //txt文件
			$arr = json_decode(file_get_contents($txt_file), TRUE); //将txt文件文本输出并转换成数组
			foreach ($array as $key => $value) {
				$arr[$key] = urlencode($value);
			}
			$json_text = json_encode($arr); //将数组转成json
			$myfile = fopen($txt_file, "w"); //打开txt文件，以覆盖的方式写入
			$res = fwrite($myfile, $json_text); //写入数据
			fclose($myfile); //关闭文件
			if ($res) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	// 读取文件中的json数据为数组
	function get_data($txtjson_file = "./TxtDabase/data.json", $akey = '') {
		if ($akey == '') {
			//获取全部

			$all_res = json_decode(file_get_contents($txtjson_file), TRUE);
			foreach ($all_res as $key => $value) {
				$ret_arr[$key] = urldecode($value);
			}
			return $ret_arr;
		} else {
			//获取指定
			$res = json_decode(file_get_contents($txtjson_file), TRUE);
			if ($res[$akey]) {
				return urldecode($res[$akey]);
			} else {
				return FALSE;
			}
		}
	}

}
