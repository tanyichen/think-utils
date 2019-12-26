<?php
namespace yichenthink\utils;

/**
 * 数组处理
 */
class Arr {

	/**
	 * 无限分类 获取所有子分类
	 * @data  [array][['id'=>'','parent_id'=>][……]]
	 * @return array
	 */

	//递归获取某个分类的所有子分类1
	public function getSubs($categorys, $catId = 0, $level = 1) {
		$max = 115; //最大分类级数
		$subs = array();
		foreach ($categorys as $item) {
			if ($item['parent_id'] == $catId) {
				$item['level'] = $level;

				if ($level < $max) {
					$subs['parent_id'] = $this->getSubs($categorys, $item['id'], $level + 1);
				}
				$subs[] = $item;
			}

		}
		return $subs;
	}
	/**
	 * 将数据格式化成树形结构 注意id===数组索引
	 * 要点 如果存在父id 就把自己id作为父组的主键
	 * @author Xuefen.Tong
	 * @param array $items
	 * @return array
	 */

	public function getTree($items) {
		$tree = []; //格式化好的树
		foreach ($items as $item) {
			if (isset($items[$item['pid']])) {
				$items[$item['pid']]['children'][] = &$items[$item['id']];
			} else {
				$tree[] = &$items[$item['id']];
			}
		}

		return $tree;
	}

	// 根据数组1的值作为数组2的key，返回新数组

	public function only($arr1, $arr2) {

		$arr = [];

		switch (gettype($arr2)) {
		case 'array':
			foreach ($arr1 as $key => $value) {
				if (isset($arr2[$value])) {
					$arr[$value] = $arr2[$value];
				}
			}
			# code...
			break;
		case 'object':
			foreach ($arr1 as $key => $value) {
				if (isset($arr2->$value)) {
					$arr[$value] = $arr2->$value;
				}
			}
			# code...
			break;
		default:
			# code...
			break;
		}

		return $arr;
	}

	// 多维数组差值支持对象
	public function array_diff1($arr_1, $arr_2) {
		$type2 = gettype($arr_2);
		$type1 = gettype($arr_1);

		switch ($type2) {
		case 'array':
			foreach ($arr_1 as $key => $val) {

				switch ($type1) {
				case 'array':
					if (isset($arr_2[$key]) && $arr_2[$key] == $val) {
						unset($arr_1[$key]);
					}
					# code...
					break;
				case 'object':
					if (isset($arr_2[$key]) && $arr_2[$key] == $val) {
						unset($arr_1->$key);
					}
					# code...
					break;

				default:
					# code...
					break;
				}

			}
			# code...
			break;
		case 'object':
			switch ($type1) {
			case 'array':
				foreach ($arr_1 as $key => $val) {

					if (isset($arr_2->$key) && $arr_2->$key == $arr_1[$key]) {
						unset($arr_1[$key]);
					}

				}
				break;
			case 'object':
				if (isset($arr_2->$key) && $arr_2->$key == $val) {
					unset($arr_1->$key);
				}
				# code...
				break;

			default:
				# code...
				break;
			}
			# code...
			break;
		default:
			# code...
			break;
		}

		return $arr_1;
	}

}
