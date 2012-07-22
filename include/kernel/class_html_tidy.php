<?php
class html_tidy
{
	/**
	 * 过滤的HTML标签
	 *
	 * @var array
	 * @access public
	 */
	public $filter_html_tag = array('script', 'frameset', 'frame', 'iframe', 'applet', 'base', 'layer', 'ilayer');

	/**
	 * 参数设置
	 *
	 * 设置tidy参数
	 *
	 * @var array
	 * @access public
	 */
	public $tidy_conf = array(
		//'bare'              => TRUE,
		'output-xhtml'      => TRUE,/*输出为XHTML规范*/
		//'show-body-only'    => TRUE,
		'newline'           => FALSE,/*不换行*/
		//'preserve-entities' => TRUE,
		'show-warnings'     => FALSE,/*不显示警告信息*/
		'show-errors'       => 0,/*不显示错误信息*/
		'alt-text'          => 'Image',/*默认alt值(用于IMG标签)*/
	);

	/******* 私有成员变量 *******/

	/**
	 * 非配对标签
	 *
	 * <tag />
	 *
	 * @var array
	 * @access public
	 */
	private $_single_html_tag = array('area', 'input', 'br', 'img', 'hr', 'wbr');

	/**
	 * 整理后的html字符串
	 *
	 * @var string
	 * @access private
	 */
	private $_clean_html_str = '';


	/**
	 * 构造函数
	 *
	 * 一个空的构造函数
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * 执行HTML整理
	 *
	 * @access public
	 * @param string $html_code
	 * @param string $encoding
	 * @return string
	 */
	public function Execute($html_code, $encoding = 'utf-8')
	{
		$this->_clean_html_str = '';

		if ('utf-8' != $encoding) $html_code = iconv($encoding, 'utf-8', $html_code);

		if ('' != $html_code)
		{
			if (!function_exists('tidy_parse_string'))
			{
				die('tidy error');
			}
			$tidy = tidy_parse_string($html_code, $this->tidy_conf, 'utf8');
			$body = $tidy->body();
			if ($body->child)
			{
				foreach ($body->child as $child)
				{
					$this->_clean($child);
				}
			}
		}

		return 'utf-8' != $encoding ? iconv('utf-8', $encoding, $this->_clean_html_str) : $this->_clean_html_str;
	}

	/**
	 * 处理HTML字符串
	 *
	 * 递归处理每个HTML节点
	 *
	 * @access private
	 * @param object $node
	 * @return void
	 */
	private function _clean($node)
	{
		// 被过滤的标签
		if (in_array($node->name, $this->filter_html_tag))
		{
			return;
		}

		// 文字节点,直接加入
		if (TIDY_NODETYPE_TEXT == $node->type)
		{
			$this->_clean_html_str .= $node->value;
			return;
		}

		$this->_clean_html_str .= '<'.$node->name;

		// 不是文字节点
		// 处理节点属性
		if ($node->attribute)
		{
			if ('img' == $node->name)
			{
				$this->_clean_html_str .= ' alt="#PIC_ALT#" onclick="window.open(\'#PIC_URL#\');"';
			}

			if ('a' == $node->name)
			{
				$this->_clean_html_str .= ' target="_blank"';
			}

			foreach ($node->attribute as $name=>$value)
			{
				if ('img' == $node->name)
				{
					if ('alt' == $name || 'title' == $name || 'onclick' == $name) continue;
				}

				if ('target' == $name) continue;

				// 过滤id和dom事件
				if ('id' != $name && !preg_match('#^on[a-z]+#i', $name))
				{
					if (!preg_match('#javascript#i', $value))
					{
						$this->_clean_html_str .= ' '.$name.'="'.htmlspecialchars($value).'"';
					}
				}
			}
		}

		// 非配对标签
		if (TIDY_NODETYPE_STARTEND == $node->type || in_array($node->name, $this->_single_html_tag))
		{
			$this->_clean_html_str .= ' />';
		}
		else
		{
			// 有子节点,递归处理子节点
			if ($node->child)
			{
				$this->_clean_html_str .= '>';

				foreach($node->child as $child)
				{
					$this->_clean($child);
				}

				$this->_clean_html_str .= '</'.$node->name.'>';
			}
			else
			{
				$this->_clean_html_str .= '></'.$node->name.'>';
			}
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