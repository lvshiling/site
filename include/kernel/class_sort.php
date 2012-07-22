<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class Sort
{
	// 分类树
	public $SortTree = array();
	// 所有分类
	public $SortList = array();
	// 所有一级分类
	public $SortOneList = array();

	// 父分类树
	private $ParentTree = array();

	// 分类数据
	private $SortData;

	// 全局配置
	private $Config;

	// 默认被选中的分类(只用于下拉菜单)
	private $DefaultSelectID = 0;


	public function __construct($config)
	{
		$this->Config = $config;
		$this->GetAllSort();
	}


	/**
	 *
	 * 取select下拉菜单
	 *
	 * $select_name: select菜单元素名
	 * $default_id: select默认选中的
	 * $break_sort_id: 循环到某个分枝的某个点上时不再继续向下展开
	 */
	public function GetSortOption($default_id = '', $break_sort_id = '')
	{
		// 默认选择的分类
		$this->DefaultSelectID = $default_id;

		$this->SortData = '';

		$this->BuildSortOption(0, '', $break_sort_id);

		return $this->SortData;
	}


	/**
	 *
	 * 取分类列表数据
	 *
	 */
	public function GetList()
	{
		$this->SortData = '';

		$this->BuildList();

		return $this->SortData;
	}


	/**
	 *
	 * 取得某一分类下的所有分支
	 *
	 */
	public function GetChild($sort_id)
	{
		$this->SortData = array();

		$this->BuildChild($sort_id);

		return $this->SortData;
	}


	/**
	 *
	 * 取得当前分类的上一级分类
	 *
	 */
	public function GetParentTree($sort_id)
	{
		$this->ParentTree = array();

		$this->GetParent($this->SortList[$sort_id]['parent']);

		$this->ParentTree && arsort($this->ParentTree);

		return $this->ParentTree;
	}


	/**
	 *
	 * 取得某一分类上的所有单线父分类
	 * parent1->parent-2->sort_id
	 *
	 */
	private function GetParent($parent_id)
	{
		if (0 == $parent_id) return;

		$this->ParentTree[$parent_id] = $this->SortList[$parent_id]['name'];
		$this->GetParent($this->SortList[$parent_id]['parent']);
	}


	/**
	 *
	 * 获取子分类
	 *
	 */
	private function BuildChild($sort_id)
	{
		if ($this->SortTree[$sort_id])
		{
			foreach ($this->SortTree[$sort_id] as $sort_id)
			{
				$this->SortData[] = $sort_id;
				$this->BuildChild($sort_id);
			}
		}
	}


	/**
	 *
	 * 下拉菜单形式的分类显示
	 *
	 * @access private
	 *
	 */
	private function BuildSortOption($parent_id = 0, $append = '', $break_sort_id = '')
	{
		if ($this->SortTree[$parent_id])
		{
			foreach ($this->SortTree[$parent_id] as $sort_id)
			{
				$option_value = $sort_id;
				$option_title = $append.strip_tags($this->SortList[$sort_id]['name']);
				if (!$this->SortList[$sort_id]['post'] && 'www' == TEMPLATE_SUB_DIR)
				{
					$option_value = '';
				}
				$this->SortData .= '<option value="'.$option_value.'"'.($this->DefaultSelectID==$sort_id?' selected="selected"':'').'>'.$option_title.'</option>';
				if ($sort_id != $break_sort_id)
				{
					$this->BuildSortOption($sort_id, $append.'&nbsp;&nbsp;&nbsp;&nbsp;', $break_sort_id);
				}
			}
		}
	}


	/**
	 *
	 * 取得所有缓存的分类
	 *
	 * @access private
	 * @return void
	 *
	 */
	private function GetAllSort()
	{
		$cache_file_path = $this->Config['dir']['data'].'/cache/sort.php';
		if (file_exists($cache_file_path) && !$this->SortList)
		{
			include_once($cache_file_path);
			$this->SortList = $sort_list;
			$this->SortTree = $sort_tree;
			$this->SortOneList = $this->SortTree[0];
		}
	}


	public function __destruct()
	{
		unset($this->AllSort);
	}
}
?>