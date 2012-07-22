<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// ѭ����ʾ����
if (!defined('LOOP_PAGE_NUM')) define('LOOP_PAGE_NUM', 4);

final class Multipage
{
	/******* ������Ա���� *******/

	public $PageType = 'php';

	public $RequestURI = '';

	/**
	 * ��¼ƫ����
	 *
	 * @var     integer
	 * @access  public
	 */
	public $Offset = 0;

	/**
	 * ��ҳ��
	 *
	 * var      integer
	 * @access  public
	 */
	public $TotalPage;

	/**
	 * ��ǰҳ
	 *
	 * @var     integer
	 * @access  public
	 */
	public $CurrentPage;

	/**
	 * ��ҳ������
	 *
	 * @var string
	 * @access  public
	 */
	public $PageVarName = 'page';

	/**
	 * �Ƿ���ʾ��ҳ��ѭ������
	 *
	 * @var     boolean
	 * @access  public
	 */
	public $ShowLoopPage = TRUE;


	/******* ˽�г�Ա���� *******/

	private $core;

	/**
	 * ��������
	 *
	 * @var     string
	 * @access  private
	 */
	private $PageUrl;
	private $PageUrlAppend;

	/**
	 * �ܼ�¼��
	 *
	 * var      integer
	 * @access  protected
	 */
	private $TotalNum;

	/**
	 * ÿҳ��ʾ����
	 *
	 * @var     integer
	 * @access  protected
	 */
	private $PerPage;



	/**
	 * ���캯��
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
	 * ��ʾ��ҳ
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
			// ������ַ����ַ
			$this->PageUrl = $this->ParseUrl();

			$pages  = $this->GetPrePage();
			$pages .= $this->GetFirstPage();

			// �Ƿ���ʾѭ������
			if (TRUE === $this->ShowLoopPage)
			{
				$pages .= $this->GetLoopPageNum();
			}

			$pages .= $this->GetEndPage();
			$pages .= $this->GetNextPage();
		}

		return $pages;
	}


	/**
	 * �������������ַ���
	 *
	 * ȥ��?��������ķ�ҳ���� $this->PageVarName
	 *
	 * @access private
	 * @return string
	 */
	private function ParseUrl()
	{
		if (empty($this->RequestURI)) $this->RequestURI = urldecode(REQUEST_URI);

		$this->RequestURI = stripslashes($this->RequestURI);

		$this->RequestURI = preg_replace('#\?$#', '', $this->RequestURI);

		if ('html' == $this->PageType)
		{
			$this->PageUrlAppend = '.html';

			//$request_uri = substr(0, strripos('/', $request_uri), $request_uri);

			return preg_replace('#([1-9]{1}\d*\.html)?|\?.*$#', '', $this->RequestURI);
		}

		$tmp_ = parse_url($this->RequestURI);
		$tempurl = $tmp_['query'];

		if (!empty($tempurl))
		{
			parse_str($tempurl, $param_array);
			if (array_key_exists($this->PageVarName, $param_array))
			{
				unset($param_array[$this->PageVarName]);
			}
			// ���ɾ���url����������ַ���
			$tempurl  = http_build_query($param_array);
			// ������鲻Ϊ��, ��β�ͼ���&amp;
			if (0 < count($param_array))
			{
				$tempurl .= '&amp;';
			}
		}

		$_SERVER['PHP_SELF'] = preg_match('#\/$#', $_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'].'index.php' : $_SERVER['PHP_SELF'];

		return $_SERVER['PHP_SELF'].'?'.$tempurl.$this->PageVarName.'=';
	}


	/**
	 * ��ҳ
	 *
	 * @access private
	 * @return string
	 */
	private function GetFirstPage()
	{
		// ���������������֮һʱ, ��ʾ��ҳ
		// 1.����ѭ����ʾ��Χ
		// 2.����ʾѭ����ҳ
		if ((1 < ($this->CurrentPage - LOOP_PAGE_NUM)) || (FALSE === $this->ShowLoopPage && 2 < $this->CurrentPage))
		{
			return '<a href="'.$this->PageUrl.'1'.$this->PageUrlAppend.'" class="pager-first active" target="_self">1</a>';
		}

		return '';
	}


	/**
	 * ĩҳ
	 *
	 * @access private
	 * @return string
	 */
	private function GetEndPage()
	{
		// ���������������֮һʱ, ��ʾĩҳ
		// 1.����ѭ����ʾ��Χ
		// 2.����ʾѭ����ҳ
		if (LOOP_PAGE_NUM < ($this->TotalPage - $this->CurrentPage) || (FALSE === $this->ShowLoopPage && ($this->TotalPage-1) > $this->CurrentPage))
		{
			return '<a href="'.$this->PageUrl.$this->TotalPage.$this->PageUrlAppend.'" class="pager-last active" target="_self">'.$this->TotalPage.'</a>';
		}

		return '';
	}


	/**
	 * ��һҳ
	 *
	 * @access private
	 * @return string
	 */
	private function GetPrePage()
	{
		if (1 < $this->CurrentPage)
		{
			return '<a href="'.$this->PageUrl.($this->CurrentPage - 1).$this->PageUrlAppend.'" class="nextprev" target="_self">&laquo; '.$this->core->Language['multipage']['previous'].'</a>';
		}

		return '<span class="nextprev">&laquo; '.$this->core->Language['multipage']['previous'].'</span>';
	}


	/**
	 * ��һҳ
	 *
	 * @access private
	 * @return string
	 */
	private function GetNextPage()
	{
		if ($this->TotalPage > $this->CurrentPage)
		{
			return '<a href="'.$this->PageUrl.($this->CurrentPage + 1).$this->PageUrlAppend.'" class="nextprev" target="_self">'.$this->core->Language['multipage']['next'].' &raquo;</a>';
		}

		return '<span class="nextprev">'.$this->core->Language['multipage']['next'].' &raquo;</span>';
	}


	/**
	 * ѭ��ҳ��
	 *
	 * @access private
	 * @return string
	 */
	private function GetLoopPageNum()
	{
		// ѭ����ʼ��ֵ
		$loop_start_num = $this->CurrentPage - LOOP_PAGE_NUM;
		$loop_start_num = $loop_start_num < 1 ? 1 : $loop_start_num;
		// ѭ��������ֵ
		$loop_end_num = $this->CurrentPage + LOOP_PAGE_NUM;
		$loop_end_num = $loop_end_num > $this->TotalPage ? $this->TotalPage : $loop_end_num;

		$loop_page_num = '';
		if (1 < $this->CurrentPage - 5) $loop_page_num .= '<span>&#8230;.</span>';
		for ($pagenum = $loop_start_num; $pagenum <= $loop_end_num; $pagenum++)
		{
			if ($this->CurrentPage == $pagenum)
			{
				$loop_page_num .= '<span class="current">'.$pagenum.'</span>';
			}
			else
			{
				$loop_page_num .= '<a href="'.$this->PageUrl.$pagenum.$this->PageUrlAppend.'" target="_self">'.$pagenum.'</a>';
			}
		}
		if ($this->CurrentPage < $this->TotalPage - 5) $loop_page_num .= '<span>&#8230;.</span>';

		return $loop_page_num;
	}


	/**
	 * ������ҳ��
	 *
	 * ���ݼ�¼������ÿҳ��ʾ�����õ���ҳ��
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
	 * ����ÿҳ��ʾ����
	 *
	 * ���ɹ��캯�����յ�ÿҳ��ʾ����ֵ���м��
	 *
	 * @access private
	 * @param integer $perpage
	 * @return integer
	 */
	private function SetPerPage($perpage)
	{
		// ����õ���ֵС��1,��ʹ��Ĭ��ֵ30
		return ($perpage + 0) === 0 ? 30 : $perpage;
	}


	/**
	 * ��ǰҳ
	 *
	 * ���ɹ��캯�����յĵ�ǰҳֵ���м��
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
	 * ���ü�¼ƫ����
	 *
	 * �������ݿ��ѯ��ƫ����
	 *
	 * @access: private
	 * @return: integer
	 */
	private function SetOffset()
	{
		return ($this->CurrentPage - 1) * $this->PerPage;
	}

	/**
	 * ��������
	 *
	 * һ���յ���������
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