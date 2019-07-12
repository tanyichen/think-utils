<?php
namespace yichenthink\utils;

/**
 * 检查器
 */
class Check {

	/**
	 * 根据用户名 判断是手机还是 邮箱
	 * @username  string
	 * @return email
	 */
	public static function checkUsernameType($username = '188888') {
		/*********** 判断是否为邮箱  ***********/
		$is_email = \Validate::is($username, 'email') ? 1 : 0;
		/*********** 判断是否为手机  ***********/
		$is_phone = preg_match('/^1[34578]\d{9}$/', $username) ? 4 : 2;
		/*********** 最终结果  ***********/
		$flag = $is_email + $is_phone;
		switch ($flag) {
		/*********** not phone not email  ***********/
		case 2:
			Utils('Send')->returnmsg(400, '邮箱或手机号不正确!');
			break;
		/*********** is email not phone  ***********/
		case 3:
			return 'email';
			break;
		/*********** is phone not email  ***********/
		case 4:
			return 'phone';
			break;
		}
	}
}
