<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class Sort
{
	// ������
	public $SortTree = array();
	// ���з���
	public $SortList = array();
	// ����һ������
	public $SortOneList = array();

	// ��������
	private $ParentTree = array();

	// ��������
	private $SortData;

	// ȫ������
	private $Config;

	// Ĭ�ϱ�ѡ�еķ���(ֻ���������˵�)
	private $DefaultSelectID = 0;


	public function __construct($config)
	{
		$this->Config = $config;
		$this->GetAllSort();
	}


	/**
	 *
	 * ȡselect�����˵�
	 *
	 * $select_name: select�˵�Ԫ����
	 * $default_id: selectĬ��ѡ�е�
	 * $break_sort_id: ѭ����ĳ����֦��ĳ������ʱ���ټ�������չ��
	 */
	public function GetSortOption($default_id = '', $break_sort_id = '')
	{
		// Ĭ��ѡ��ķ���
		$this->DefaultSelectID = $default_id;

		$this->SortData = '';

		$this->BuildSortOption(0, '', $break_sort_id);

		return $this->SortData;
	}


	/**
	 *
	 * ȡ�����б�����
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
	 * ȡ��ĳһ�����µ����з�֧
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
	 * ȡ�õ�ǰ�������һ������
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
	 * ȡ��ĳһ�����ϵ����е��߸�����
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
	 * ��ȡ�ӷ���
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
	 * �����˵���ʽ�ķ�����ʾ
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
	 * ȡ�����л���ķ���
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