<?php
class html_tidy
{
	/**
	 * ���˵�HTML��ǩ
	 *
	 * @var array
	 * @access public
	 */
	public $filter_html_tag = array('script', 'frameset', 'frame', 'iframe', 'applet', 'base', 'layer', 'ilayer');

	/**
	 * ��������
	 *
	 * ����tidy����
	 *
	 * @var array
	 * @access public
	 */
	public $tidy_conf = array(
		//'bare'              => TRUE,
		'output-xhtml'      => TRUE,/*���ΪXHTML�淶*/
		//'show-body-only'    => TRUE,
		'newline'           => FALSE,/*������*/
		//'preserve-entities' => TRUE,
		'show-warnings'     => FALSE,/*����ʾ������Ϣ*/
		'show-errors'       => 0,/*����ʾ������Ϣ*/
		'alt-text'          => 'Image',/*Ĭ��altֵ(����IMG��ǩ)*/
	);

	/******* ˽�г�Ա���� *******/

	/**
	 * ����Ա�ǩ
	 *
	 * <tag />
	 *
	 * @var array
	 * @access public
	 */
	private $_single_html_tag = array('area', 'input', 'br', 'img', 'hr', 'wbr');

	/**
	 * ������html�ַ���
	 *
	 * @var string
	 * @access private
	 */
	private $_clean_html_str = '';


	/**
	 * ���캯��
	 *
	 * һ���յĹ��캯��
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * ִ��HTML����
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
	 * ����HTML�ַ���
	 *
	 * �ݹ鴦��ÿ��HTML�ڵ�
	 *
	 * @access private
	 * @param object $node
	 * @return void
	 */
	private function _clean($node)
	{
		// �����˵ı�ǩ
		if (in_array($node->name, $this->filter_html_tag))
		{
			return;
		}

		// ���ֽڵ�,ֱ�Ӽ���
		if (TIDY_NODETYPE_TEXT == $node->type)
		{
			$this->_clean_html_str .= $node->value;
			return;
		}

		$this->_clean_html_str .= '<'.$node->name;

		// �������ֽڵ�
		// ����ڵ�����
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

				// ����id��dom�¼�
				if ('id' != $name && !preg_match('#^on[a-z]+#i', $name))
				{
					if (!preg_match('#javascript#i', $value))
					{
						$this->_clean_html_str .= ' '.$name.'="'.htmlspecialchars($value).'"';
					}
				}
			}
		}

		// ����Ա�ǩ
		if (TIDY_NODETYPE_STARTEND == $node->type || in_array($node->name, $this->_single_html_tag))
		{
			$this->_clean_html_str .= ' />';
		}
		else
		{
			// ���ӽڵ�,�ݹ鴦���ӽڵ�
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