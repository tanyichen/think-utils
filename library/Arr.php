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
}
