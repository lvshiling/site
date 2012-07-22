<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class XXList
{
	// 显示分类
	public $show_sort = FALSE;
	// 显示作者
	public $show_author = TRUE;
	// 高亮关键字
	public $heightlight = array();

	private $core;

	public function __construct($core)
	{
		$this->core = $core;
	}

	public function html($query_sql)
	{
		$query = $this->core->DB->Execute($query_sql);
		$key = 0;
		while (!$query->EOF)
		{
			$data[$key] = $query->fields;

			// 标题风格
			if (!empty($query->fields['title_style']))
			{
				$_style = '<span style="';
				$title_style = explode('|', $query->fields['title_style']);
				if ($title_style[0]) $_style .= 'color:'.$title_style[0].';';
				if ($title_style[1]) $_style .= 'font-weight:bold;';
				if ($title_style[2]) $_style .= 'text-decoration:line-through;';
				if ($title_style[3]) $_style .= 'font-style:italic;';
				$_style .= '">';

				$data[$key]['data_title'] = $_style.$query->fields['data_title'].'</span>';
			}

			if ($this->heightlight)
			{
				$data[$key]['data_title'] = $this->HeightlightKeyword($data[$key]['data_title'], $this->heightlight);
			}

			if ($this->show_sort)
			{
				$data[$key]['sort_id'] = $query->fields['sort_id'];
				$data[$key]['sort_name'] = $this->core->sort->SortList[$query->fields['sort_id']]['name'];
				//$data[$key]['sort_url'] = $this->core->sort->SortList[$query->fields['sort_id']]['url'];
			}

			if (IS_VIP || $this->core->sort->SortList[$query->fields['sort_id']]['vip'])
			{
				$data[$key]['show_url'] = $this->core->Config['domain_vip'].'/show-'.$data[$key]['hash_id'].'.html';
			}
			else
			{
				$data[$key]['show_url'] = $this->core->Config['domain_www'].'/go.html?p='.$this->core->UrlEncryptParame($data[$key]['data_id'], $data[$key]['release_date']);
				//$data[$key]['show_url'] = $this->core->Config['domain_www'].'/show/'.date('Y/md', $data[$key]['release_date']).'/'.$data[$key]['data_id'].'.html';
			}

			if (!$this->show_author)
			{
				unset($data[$key]['user_id']);
				unset($data[$key]['user_name']);
			}

			$key++;
			$query->MoveNext();
		}

		return $data;
	}

	/**
	 * 高亮关键字
	 *
	 * @access public
	 * @return string
	 */
	private function HeightlightKeyword($text, $replace)
	{
		if (!$replace || empty($text)) return $text;

		foreach ($replace as $key=>$r)
		{
			if (empty($r))
			{
				unset($replace[$key]);
			}
			else
			{
				$replace[$key] = '#('.preg_quote($r, '#').')#iUs';
			}
		}

		if (!$replace) return $text;

		return preg_replace($replace, '<span class="keyword">\\1</span>', $text);
	}

	/**
	 * 析构函数
	 *
	 * 一个空的析构函数
	 *
	 * @access public
	 * @return void
	 */
	public function __destruct()
	{
		// void
	}
}

?>