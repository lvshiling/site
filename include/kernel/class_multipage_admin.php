<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// 循环显示数量
if (!defined('LOOP_PAGE_NUM')) define('LOOP_PAGE_NUM', 4);

final class Multipage
{
	/******* 公共成员变量 *******/

	public $PageType = 'php';

	/**
	 * 记录偏移量
	 *
	 * @var     integer
	 * @access  public
	 */
	public $Offset = 0;

	/**
	 * 总页数
	 *
	 * var      integer
	 * @access  public
	 */
	public $TotalPage;

	/**
	 * 当前页
	 *
	 * @var     integer
	 * @access  public
	 */
	public $CurrentPage;

	/**
	 * 分页变量名
	 *
	 * @var string
	 * @access  public
	 */
	public $PageVarName = 'page';

	/**
	 * 是否显示分页的循环部分
	 *
	 * @var     boolean
	 * @access  public
	 */
	public $ShowLoopPage = TRUE;


	/******* 私有成员变量 *******/

	private $core;

	/**
	 * 访问链接
	 *
	 * @var     string
	 * @access  private
	 */
	private $PageUrl;
	private $PageUrlAppend;

	/**
	 * 总记录数
	 *
	 * var      integer
	 * @access  protected
	 */
	private $TotalNum;

	/**
	 * 每页显示条数
	 *
	 * @var     integer
	 * @access  protected
	 */
	private $PerPage;



	/**
	 * 构造函数
	 *
	 * @access public
	 * @param integer $totalnum
	 * @param integer $curren_tpage
	 * @param integer $perpage
	 * @return void
	 */
	public function __construct($core, $totalnum, $current_page, $perpage = 30)
	{
		$this->core = $core;

		$this->TotalNum    = $totalnum;
		$this->PerPage     = $this->SetPerPage($perpage);
		$this->TotalPage   = $this->SetTotalPage();
		$this->CurrentPage = $this->SetCurrentPage($current_page);
		$this->Offset      = $this->SetOffset();
	}


	/**
	 * 显示分页
	 *
	 * Usage: $page->ShowMultiPage();
	 *
	 * @access public
	 * @return string
	 */
	public function ShowMultiPage()
	{
		if (1 < $this->TotalPage)
		{
			// 解析地址栏地址
			$this->PageUrl = $this->ParseUrl();

			$pages  = $this->GetFirstPage();
			$pages .= $this->GetPrePage();

			// 是否显示循环部分
			if (TRUE === $this->ShowLoopPage)
			{
				$pages .= $this->GetLoopPageNum();
			}

			$pages .= $this->GetNextPage();
			$pages .= $this->GetEndPage();
		}

		return $pages;
	}


	/**
	 * 分页统计
	 *
	 * Usage: $page->PageInfo();
	 *
	 * @access public
	 * @return string
	 */
	public function PageInfo()
	{
		if (1 < $this->TotalPage)
		{
			return '<span class="pageinfo">'.$this->core->LangReplaceText($this->core->Language['multipage']['page_info'], $this->CurrentPage, $this->TotalPage).'</span>';
		}
	}


	/**
	 * 页面跳转
	 *
	 * Usage: $page->ShowJumpPage();
	 *
	 * @access public
	 * @return string
	 */
	public function ShowJumpPage()
	{
		/*
		if (1 < $this->TotalPage)
		{
			$page_url_append = '' != $this->PageUrlAppend ? '+\''.$this->PageUrlAppend.'\'' : $this->PageUrlAppend;

			return '转到第<input type="text" name="pagenum" class="in_04" size="2" maxlength="5" onkeyup="this.value=this.value.replace(/[^\d]/g, \'\');" />页<input type="button" class="in_02" value="确定" onclick="location.href=\''.$this->PageUrl.'\'+pagenum.value'.$page_url_append.'" />';
		}
		*/
	}


	/**
	 * 分析链接请求字符串
	 *
	 * 去除?后面包含的分页变量 $this->PageVarName
	 *
	 * @access private
	 * @return string
	 */
	private function ParseUrl()
	{
		$request_uri = urldecode(REQUEST_URI);
		$request_uri = stripslashes($request_uri);

		$request_uri = preg_replace('#\?$#', '', $request_uri);

		if ('html' == $this->PageType)
		{
			$this->PageUrlAppend = '.html';

			//$request_uri = substr(0, strripos('/', $request_uri), $request_uri);

			return preg_replace('#([1-9]{1}\d*\.html)?|.*\.php$#', '', $request_uri);
		}

		$tmp_ = parse_url($request_uri);
		$tempurl = $tmp_['query'];

		if (!empty($tempurl))
		{
			parse_str($tempurl, $param_array);
			if (array_key_exists($this->PageVarName, $param_array))
			{
				unset($param_array[$this->PageVarName]);
			}
			// 生成经过url编码的请求字符串
			$tempurl  = http_build_query($param_array);
			// 如果数组不为空, 结尾就加上&amp;
			if (0 < count($param_array))
			{
				$tempurl .= '&amp;';
			}
		}

		$_SERVER['PHP_SELF'] = preg_match('#\/$#', $_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'].'index.php' : $_SERVER['PHP_SELF'];

		return $_SERVER['PHP_SELF'].'?'.$tempurl.$this->PageVarName.'=';
	}


	/**
	 * 首页
	 *
	 * @access private
	 * @return string
	 */
	private function GetFirstPage()
	{
		// 满足以下两种情况之一时, 显示首页
		// 1.超出循环显示范围
		// 2.不显示循环分页
		if ((1 < ($this->CurrentPage - LOOP_PAGE_NUM)) || (FALSE === $this->ShowLoopPage && 2 < $this->CurrentPage))
		{
			return '<span class="firstpage"><a href="'.$this->PageUrl.'1'.$this->PageUrlAppend.'" target="_self">'.$this->core->Language['multipage']['home'].'</a></span>';
		}

		return '';
	}


	/**
	 * 末页
	 *
	 * @access private
	 * @return string
	 */
	private function GetEndPage()
	{
		// 满足以下两总情况之一时, 显示末页
		// 1.超出循环显示范围
		// 2.不显示循环分页
		if (LOOP_PAGE_NUM < ($this->TotalPage - $this->CurrentPage) || (FALSE === $this->ShowLoopPage && ($this->TotalPage-1) > $this->CurrentPage))
		{
			return '<span class="endpage"><a href="'.$this->PageUrl.$this->TotalPage.$this->PageUrlAppend.'" target="_self">'.$this->core->Language['multipage']['last'].'</a></span>';
		}

		return '';
	}


	/**
	 * 上一页
	 *
	 * @access private
	 * @return string
	 */
	private function GetPrePage()
	{
		if (1 < $this->CurrentPage)
		{
			return '<span class="prepage"><a href="'.$this->PageUrl.($this->CurrentPage - 1).$this->PageUrlAppend.'" target="_self">'.$this->core->Language['multipage']['previous'].'</a></span>';
		}

		return '';
	}


	/**
	 * 下一页
	 *
	 * @access private
	 * @return string
	 */
	private function GetNextPage()
	{
		if ($this->TotalPage > $this->CurrentPage)
		{
			return '<span class="nextpage"><a href="'.$this->PageUrl.($this->CurrentPage + 1).$this->PageUrlAppend.'" target="_self">'.$this->core->Language['multipage']['next'].'</a></span>';
		}

		return '';
	}


	/**
	 * 循环页数
	 *
	 * @access private
	 * @return string
	 */
	private function GetLoopPageNum()
	{
		// 循环开始数值
		$loop_start_num = $this->CurrentPage - LOOP_PAGE_NUM;
		$loop_start_num = $loop_start_num < 1 ? 1 : $loop_start_num;
		// 循环结束数值
		$loop_end_num = $this->CurrentPage + LOOP_PAGE_NUM;
		$loop_end_num = $loop_end_num > $this->TotalPage ? $this->TotalPage : $loop_end_num;

		$loop_page_num = '';
		for ($pagenum = $loop_start_num; $pagenum <= $loop_end_num; $pagenum++)
		{
			if ($this->CurrentPage == $pagenum)
			{
				$loop_page_num .= '<span class="active">'.$pagenum.'</span>';
			}
			else
			{
				$loop_page_num .= '<span class="looppage"><a href="'.$this->PageUrl.$pagenum.$this->PageUrlAppend.'" target="_self">'.$pagenum.'</a></span>';
			}
		}

		return $loop_page_num;
	}


	/**
	 * 计算总页数
	 *
	 * 根据记录总数和每页显示数量得到总页数
	 *
	 * @access private
	 * @return integer
	 */
	private function SetTotalPage()
	{
		if (0 === $this->TotalNum)
		{
			return 0;
		}

		return ceil($this->TotalNum / $this->PerPage);
	}


	/**
	 * 设置每页显示条数
	 *
	 * 对由构造函数接收的每页显示条数值进行检查
	 *
	 * @access private
	 * @param integer $perpage
	 * @return integer
	 */
	private function SetPerPage($perpage)
	{
		// 如果得到的值小于1,则使用默认值30
		return ($perpage + 0) === 0 ? 30 : $perpage;
	}


	/**
	 * 当前页
	 *
	 * 对由构造函数接收的当前页值进行检查
	 *
	 * @access private
	 * @param integer $current_page
	 * @return integer
	 */
	private function SetCurrentPage($current_page)
	{
		$current_page = intval($current_page);
		$current_page = $current_page < 1 ? 1: $current_page;
		$current_page = $current_page > $this->TotalPage ? $this->TotalPage : $current_page;

		return $current_page;
	}


	/**
	 * 设置记录偏移量
	 *
	 * 用于数据库查询的偏移量
	 *
	 * @access: private
	 * @return: integer
	 */
	private function SetOffset()
	{
		return ($this->CurrentPage - 1) * $this->PerPage;
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