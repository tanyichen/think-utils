<?php
namespace yichenthink\utils;

/**
 * 请求类
 */
class Request {

	function __construct() {
		# code...
	}
/**
 * 发送HTTP请求方法，目前只支持CURL发送请求
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
	public function http($url, $params = ["apc" => 123], $method = 'GET', $header = array(), $multi = false) {
		$opts = array(CURLOPT_TIMEOUT => 30, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HTTPHEADER => $header);

		/* 根据请求类型设置特定参数 */
		switch (strtoupper($method)) {
		case 'GET':
			$opts[CURLOPT_URL] = $url . '&' . http_build_query($params);
			// dump($opts[CURLOPT_URL]);
			break;
		case 'POST':
			//判断是否传输文件
			$params = $multi ? $params : http_build_query($params);
			$opts[CURLOPT_URL] = $url;

			// dump($opts[CURLOPT_URL]);
			$opts[CURLOPT_POST] = 1;
			$opts[CURLOPT_POSTFIELDS] = $params;
			break;
		default:
			throw new Exception('不支持的请求方式！');
		}

		$postdata = http_build_query($params);
		$options = array(
			'http' => array(
				'method' => 'GET',
				'header' => 'Content-type:application/x-www-form-urlencoded',
				'content' => $postdata,
				'timeout' => 15 * 60, // 超时时间（单位:s）
			),
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		return $result;
	}
	/**
	 * get请求 【方法2】
	 */
	public function GetCurl($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		$resp = curl_exec($curl);
		// print_r($resp);
		curl_close($curl);
		return $resp;
	}
}