<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');
set_time_limit(0);

// 生成HTML静态页
final class Html
{
	private $core;

	private $html_dir;
	private $tidy;

	static $parse;


	public function __construct($core)
	{
		$this->html_dir = ROOT_PATH.'/html';
		$this->core = $core;

		require_once(ROOT_PATH.'/include/kernel/class_html_tidy.php');
		$this->tidy = new html_tidy();
	}

	// 开始创建
	public function Create($type)
	{
		if (!$this->core->sort) return;

		if (preg_match('#^[1-9]\d*$#', $type))
		{
			$this->page_show($type);
		}
		else
		{
			$type = 'create_'.$type;
			$this->$type();
		}
	}

	// 单条数据
	public function page_show($id)
	{
		$id = intval($id);
		$data = $this->core->DB->GetRow("SELECT d.*, de.data_content FROM {$this->core->TablePre}data AS d, {$this->core->TablePre}data_ext AS de WHERE d.data_id=de.data_id AND d.data_id='{$id}'");
		if (!$data) return FALSE;

		if (!$data['is_auditing'] || $data['mark_deleted']) return FALSE;
		if ($this->core->sort->SortList[$data['sort_id']]['vip'] || $this->core->sort->SortList[$data['sort_id']]['external'])
		{
			return FALSE;
		}

		// 所属分类树
		$sub_nav = '';
		$parent_tree = $this->core->sort->GetParentTree($data['sort_id']);
		if ($parent_tree)
		{
			foreach ($parent_tree as $sort_id=>$sort_name)
			{
				$sub_nav .= '<a href="/sort-'.$sort_id.'-1.html">'.$sort_name.'</a> &raquo; ';
			}
		}
		$sub_nav .= '<a href="/sort-'.$data['sort_id'].'-1.html">'.$this->core->sort->SortList[$data['sort_id']]['name'].'</a>';

		$html_sub_path = 'show/'.date('Y/md', $data['release_date']);

		if (0 < $data['page_num'])
		{
			$page_break_str = '<div style="page-break-after: always"><span style="display: none">&nbsp;</span></div>';
			$contents = explode($page_break_str, $data['data_content']);
			$data['data_content'] = $contents[0];
		}
		$data['data_content'] = $this->tidy->Execute($data['data_content']);
		$data['data_content'] = $this->core->ReplaceImageInfo($data['data_content']);

		$data['show_url'] = $this->core->Config['domain_www'].'/show/'.date('Y/md', $data['release_date']).'/'.$data['data_id'].'.html';

		$disturb_text_file = ROOT_PATH.'/include/disturb_text.txt';
		if (file_exists($disturb_text_file))
		{
			$disturb_text = file_get_contents($disturb_text_file);
			$disturb_text_length = iconv_strlen($disturb_text, 'utf-8');
			$rand_num = mt_rand(0, $disturb_text_length - 100);
			$data['disturb_text'] = iconv_substr($disturb_text, $rand_num, 100, 'utf-8');
		}

		$this->core->SetTemplateDir('www');
		$this->core->tpl->assign(array(
			'SiteTitle' => $data['data_title'].' - '.strip_tags($this->core->sort->SortList[$data['sort_id']]['name']),
			'SubNav'    => $sub_nav,
			/*资源信息*/
			'Data'      => $data,
			'Multipage' => $this->core->ContentMultipage($data['data_id'], $data['page_num'], 0),
			'SortTree'  => $this->core->sort->SortTree,
			'SortList'  => $this->core->sort->SortList,
			'SortOne'   => $this->core->sort->SortOneList,
			'SpecialSortData' => $this->core->SpecialSortData(),
		));

		$html_code = $this->core->tpl->fetch('show_'.mt_rand(1, 3).'.tpl');
		$this->WriteFile($html_sub_path, $data['data_id'].'.html', $html_code);

		if ($contents)
		{
			unset($contents[0]);
			$i = 1;
			foreach ($contents as $content)
			{
				$data['data_content'] = $this->tidy->Execute($content);
				$this->core->tpl->assign(array(
					'Data'      => $data,
					'Multipage' => $this->core->ContentMultipage($data['data_id'], $data['page_num'], $i),
				));
				$html_code = $this->core->tpl->fetch('show_'.mt_rand(1, 3).'.tpl');
				$this->WriteFile($html_sub_path, $data['data_id'].'-'.$i.'.html', $html_code);
				$i++;
			}
		}

		$this->core->SetTemplateDir(TEMPLATE_SUB_DIR);
	}

	// 热门搜索关键词
	private function create_hotsearch()
	{
		$keyword_list = $this->core->KeywordTop();
		$keyword_list = strtr($keyword_list, array('\\'=>'\\\\',"'"=>"\\'",'"'=>'\\"',"\r"=>'\\r',"\n"=>'\\n','</'=>'<\/'));
		$js_content = 'document.write(\''.$keyword_list.'\');';

		$this->WriteFile('', 'hot_search.js', $js_content);
	}

	// 创建列表页面
	private function create_list()
	{
		if (!$this->core->sort->SortList) return;

		$page = intval($_GET['page']);
		$page || $page = 1;

		$sort_id = intval($_GET['sort']);
		if (0 >= $sort_id)
		{
			reset($this->core->sort->SortList);
			$sort_id = key($this->core->sort->SortList);
		}
		if (!$this->core->sort->SortList[$sort_id])
		{
			// 没有这个分类
			$this->core->Notice($core->Language['sort']['error_not_exist'], 'back');
		}
		$condition = 'is_auditing=1 AND mark_deleted=0';
		$child_sort = $this->core->sort->GetChild($sort_id);
		if (is_array($child_sort) && $child_sort)
		{
			$exists_sub_sort = TRUE;
			$child_sort[] = $sort_id;
			$condition .= " AND sort_id IN(".implode(',', $child_sort).")";
		}
		else
		{
			$condition .= " AND sort_id='{$sort_id}'";
		}

		// 取得父分类树
		$sub_nav = '';
		$parent_tree = $this->core->sort->GetParentTree($sort_id);
		if ($parent_tree)
		{
			foreach ($parent_tree as $sid=>$sort_name)
			{
				$sub_nav .= '<a href="/sort-'.$sid.'-1.html">'.$sort_name.'</a> &raquo; ';
			}
		}
		$sub_nav .= $this->core->sort->SortList[$sort_id]['name'];

		$total_page = 1;
		if (isset($_GET['total']))
		{
		    $total = intval($_GET['total']);
			if (!$this->core->sort->SortList[$sort_id]['vip'] && !$this->core->sort->SortList[$sort_id]['external'])
			{
				$this->core->SetTemplateDir('www');

                $total_page = ceil($total / $this->core->Config['pagination_list_num']);
                $total_page = 0 >= $total_page ? 1 : $total_page;

                $loop = 0;
				for ($i = $page; $i <= $total_page; $i++)
				{
					$this->OneList($sub_nav, $sort_id, $exists_sub_sort, $total, $i, $condition);

                    $loop++;
					if (50 <= $loop) break;
				}
				$page += $loop;
			}

			if (0 >= $total 
                || $page > $total_page 
                || $this->core->sort->SortList[$sort_id]['vip'] 
                || $this->core->sort->SortList[$sort_id]['external']
            )
			{
				// 转入下一分类
				$current_sort_id = $sort_id;
				unset($sort_id);
				// 找出下一分类
				while (current($this->core->sort->SortList))
				{
					if (key($this->core->sort->SortList) == $current_sort_id)
					{
						next($this->core->sort->SortList);
						$sort_id = key($this->core->sort->SortList);
						break;
					}
					next($this->core->sort->SortList);
				}

				// 没有分类了
				if (!$sort_id)
				{
					// 全部分类结束了
					header('Location: create_html.php?act=succeed');
					exit;
				}

				$sort_id = key($this->core->sort->SortList);
				$page = 1;
				$total = NULL;
				$total_page = 1;
			}
		}
		else
		{
			$total = $this->core->DB->GetRow("SELECT COUNT(*) AS num FROM {$this->core->TablePre}data WHERE {$condition}");
			$total = $total['num'];
		}

		$pass_parameter = array(
			'act'   => $_GET['act'],
			'sort'  => $sort_id,
			'page'  => $page,
			'total' => $total,
		);
		if (NULL === $total)
		{
			unset($pass_parameter['total']);
		}

		$goto_url = 'create_html.php?'.http_build_query($pass_parameter);
		$this->core->SetTemplateDir('admin');
		$this->core->Notice($this->core->LangReplaceText($this->core->Language['html']['waiting_batch'], $this->core->sort->SortList[$sort_id]['name'], $page, $total_page - $page, $goto_url), 'goto', $goto_url, 1);
		exit;
	}

	public function OneList($sub_nav, $sort_id, $exists_sub_sort, $total, $page, $condition)
	{
		static $list;

		// 计算总页数
		$total_page = ceil($total / $this->core->Config['pagination_list_num']);
		$total_page = 0 >= $total_page ? 1 : $total_page;
		if ($page <= $total_page)
		{
			if (0 < $total)
			{
				$offset = 0;
				if ($total > $this->core->Config['pagination_list_num'])
				{
					$multipage = $this->core->Multipage($total, $page, $this->core->Config['pagination_list_num'], 'html', '/sort-'.$sort_id.'-1.html', 'www');
					$offset = $multipage['offset'];
				}

				if (!is_object($list))
				{
					require_once(ROOT_PATH.'/include/kernel/class_list.php');
					$list = new XXList($this->core);
				}
				if ($exists_sub_sort)
				{
					$list->show_sort = TRUE;
				}
				$data = $list->html("SELECT * FROM {$this->core->TablePre}data WHERE {$condition} ORDER BY release_date DESC LIMIT $offset, {$this->core->Config['pagination_list_num']}");
			}
			$this->core->tpl->assign_by_ref('Data', $data);
			$this->core->tpl->assign(array(
				'SiteTitle'  => strip_tags($this->core->sort->SortList[$sort_id]['name']),
				'SubNav'     => $sub_nav,
				'ID'         => $sort_id,
				'SortOne'    => $this->core->sort->SortOneList,
				'SortTree'   => $this->core->sort->SortTree,
				'SortList'   => $this->core->sort->SortList,
				'Totalnum'   => $total,
				'Multipage'  => $multipage,
				'SpecialSortData' => $this->core->SpecialSortData(),
			));
			$html_code = $this->core->tpl->fetch('list_multipage.tpl');
			$this->WriteFile('', 'sort-'.$sort_id.'-'.$page.'.html', $html_code);
		}

		return $total_page;
	}

	/**
	 * 网站首页
	 *
	 */
	private function create_home()
	{
		$this->single_page('index');
	}

	/**
	 * 今日新增
	 *
	 */
	private function create_today()
	{
		$this->single_page('today');
	}

	/**
	 * 昨日新增
	 *
	 */
	private function create_yesterday()
	{
		$this->single_page('yesterday');
	}

	private function single_page($type)
	{
		$this->core->SetTemplateDir('www');
		$condition = 'is_auditing=1 AND mark_deleted=0';

		switch ($type)
		{
			case 'today':
				$condition .= " AND release_date >= UNIX_TIMESTAMP(CURRENT_DATE())";
				$site_title = $this->core->Language['html']['title_today'];
			break;
			case 'yesterday':
				$condition .= " AND release_date <= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE(), INTERVAL 1 SECOND)) AND release_date >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE(), INTERVAL 1 DAY))";
				$site_title = $this->core->Language['html']['title_yesterday'];
			break;
			default:
				$limit = " LIMIT {$this->core->Config['pagination_list_num']}";
			break;
		}

		require_once(ROOT_PATH.'/include/kernel/class_list.php');
		$list = new XXList($this->core);
		$list->show_sort = TRUE;
		$data = $list->html("SELECT * FROM {$this->core->TablePre}data WHERE {$condition} ORDER BY release_date DESC{$limit}");

		$this->core->tpl->assign_by_ref('Data', $data);
		$this->core->tpl->assign(array(
			'SiteTitle'    => $site_title,
			'ID'           => 'index' != $type ? $type : '',
			'SortOne'      => $this->core->sort->SortOneList,
			'SortTree'     => $this->core->sort->SortTree,
			'SortList'     => $this->core->sort->SortList,
			'SpecialSortData' => $this->core->SpecialSortData(),
		));
		$html_code = $this->core->tpl->fetch('list_multipage.tpl');
		$this->WriteFile('', $type.'.html', $html_code);
	}

	/**
	 * 保存HTML文件
	 *
	 */
	private function WriteFile($file_dir, $file_name, $html_code)
	{
		$html_dir = $this->core->CreateSubDir($this->html_dir, $file_dir);
		if (!$html_dir)
		{
			$this->ErrorLog('Failure to create directory:'.$file_dir);
		}

		if (!file_put_contents($html_dir.'/'.$file_name, $this->FormatHtmlCode($html_code), LOCK_EX))
		{
			$this->ErrorLog('File Generator failure:'.$html_dir.'/'.$file_name);

			return FALSE;
		}

		return TRUE;
	}

	/**
	 * 删除单记录显示页面
	 *
	 */
	public function delete_show($id, $page_num)
	{
		$id = intval($id);
		$data = $this->core->DB->GetRow("SELECT data_id, page_num, release_date FROM {$this->core->TablePre}data WHERE data_id='{$id}'");
		if (!$data) return FALSE;

		$html_file = $this->html_dir.'/show/'.date('Y/md/', $data['release_date']).$data['data_id'];

		if (file_exists($html_file.'.html'))
		{
			unlink($html_file.'.html');
		}

		if ($data['page_num'] > $page_num || 0 >= $page_num)
		{
			$page_num = $data['page_num'];
		}

		if (0 < $page_num)
		{
			for ($i = 1; $i <= $page_num; $i++)
			{
				$_html_file = $html_file.'-'.$i.'.html';
				if (file_exists($_html_file))
				{
					unlink($_html_file);
				}
			}
		}
	}

	private function FormatHtmlCode($html_code)
	{
		// 去除注释
		$html_code = preg_replace('#<\!-- .+ -->#Us', '', $html_code);

		return str_replace(array("\r\n", "\t"), '', $html_code);
		//return str_replace("\r\n", ' ', $html_code);
		//return $html_code;
	}

	// 错误日志
	private function ErrorLog($msg)
	{
		if (empty($msg)) return;

		file_put_contents(ROOT_PATH.'/data/cache/html_error.log', date('Y-m-d H:i:s', TIME_NOW).'|'.$msg."\r\n", FILE_APPEND|LOCK_EX);
	}

	// 捕获未定义的方法
	public function __call($method, $arguments)
	{
		exit('error');
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
		$this->core->SetTemplateDir(TEMPLATE_SUB_DIR);
	}
}
?>