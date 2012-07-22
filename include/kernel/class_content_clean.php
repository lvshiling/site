<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class ContentClean
{
	private $core;


	public function __construct($core)
	{
		$this->core = $core;
	}

	public function Execute(&$data)
	{
		if (!isset($this->core->Config['title_least'])) $this->core->Config['title_least'] = 10;
		if (!isset($this->core->Config['title_max'])) $this->core->Config['title_max'] = 100;
		if (!isset($this->core->Config['content_maxlength'])) $this->core->Config['content_maxlength'] = 50000;

		// 分类
		$data['sort_id'] = intval($data['sort_id']);
		if (0 >= $data['sort_id'])
		{
			$this->core->Notice($this->core->Language['content']['error_no_select_sort'], 'back');
		}

		// 标题
		$data['title'] = trim($data['title']);
		if (empty($data['title']))
		{
			$this->core->Notice($this->core->Language['content']['error_title_empty'], 'back');
		}
		$data['title'] = htmlspecialchars($data['title']);
		if ($this->core->Config['title_least'] > $this->core->CnStrlen($data['title']))
		{
			$this->core->Notice($this->core->LangReplaceText($this->core->Language['content']['error_title_length1'], $this->core->Config['title_least']), 'back');
		}
		if ($this->core->Config['title_max'] < $this->core->CnStrlen($data['title']))
		{
			$this->core->Notice($this->core->LangReplaceText($this->core->Language['content']['error_title_length2'], $this->core->Config['title_max']), 'back');
		}

		// 正文
		//$content = strip_tags($data['content']);
		/*
		if (empty($data['content']))
		{
			$this->core->Notice($this->core->Language['content']['error_content_empty'], 'back');
		}*/

		// 检查是否存在敏感字符
		$check_word = $this->core->CheckBadword($data['title'].$data['content']);
		if (TRUE !== $check_word)
		{
			$this->core->Notice($this->core->LangReplaceText($this->core->Language['content']['error_content_forbid'], $check_word), 'back');
		}

		if (!empty($data['content']))
		{
			// 内容中加入图片地址
			$data['uploaded'] = trim($data['uploaded']);
			if ($data['uploaded'])
			{
				$uploaded_arr = explode('|', $data['uploaded']);
				$match_condition = preg_quote($data['uploaded']);
				$match_condition = str_replace('\|', '|', $match_condition);
				preg_match_all('#'.$match_condition.'#iUs', stripslashes($data['content']), $match);
				$match[0] && $match[0] = array_unique($match[0]);
				$uploaded_arr = array_diff($uploaded_arr, $match[0]);
				if ($uploaded_arr)
				{
					$image_code = '';
					foreach ($uploaded_arr as $file)
					{
						$image_code .= '<p><img src="'.$file.'" /></p>';
					}
					$data['content'] .= $image_code;
				}
				unset($data['uploaded']);
			}

			if (!class_exists('html_tidy'))
			{
				require_once(ROOT_PATH.'/include/kernel/class_html_tidy.php');
			}
			$tidy = new html_tidy();
			$data['content'] = $tidy->Execute(stripslashes($data['content']));

			//require_once(ROOT_PATH.'/include/library/safehtml/safehtml.php');
			//$safehtml = new safehtml();
			//$data['content'] = $safehtml->parse(stripslashes($data['content']));
			//$safehtml->clear();

			$content_length = $this->core->CnStrlen($data['content']);
			//if (20 > $content_length)
			//{
				//$this->core->Notice($this->core->Language['content']['error_content_length1'], 'back');
			//}
			if ($this->core->Config['content_maxlength'] < $content_length)
			{
				$this->core->Notice($this->core->LangReplaceText($this->core->Language['content']['error_content_length2'], $this->core->Config['content_maxlength']), 'back');
			}

			$data['content'] = str_ireplace(
				'<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>', 
				'<div style="page-break-after: always"><span style="display: none">&nbsp;</span></div>', 
				$data['content']
			);

			$data['content'] = addslashes($data['content']);
		}

		// 检查分类是否存在
		if (!$this->core->DB->GetOne("SELECT sort_id FROM {$this->core->TablePre}sort WHERE sort_id='{$data['sort_id']}'"))
		{
			$this->core->Notice($this->core->Language['content']['error_sort_not_exist'], 'back');
		}
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