<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// ������
final class Core
{
	// ȫ������
	public $Config = array();

	// �û�����
	public $UserInfo = array('user_id'=>0, 'user_name'=>'guest');

	// ���ݿ����
	public $DB = NULL;

	// ���԰�
	public $Language = array();

	// ģ��
	public $tpl = NULL;

	// ���ݿ��ǰ׺
	public $TablePre = 'xx_';


	/**
	 *
	 * ��ʼ�����ݿ�����
	 *
	 */
	public function InitAdodb()
	{
		if ($this->DB) return;

		// ���ݿ��ǰ׺
		$this->TablePre = $this->Config['db']['prefix'];

		// Adodb���ݿ�������
		require_once(ROOT_PATH.'/include/library/adodb/adodb.inc.php');

		// ��ѯ�������ݱ���Ŀ¼
		$ADODB_CACHE_DIR = $this->Config['dir']['data'].'/cache/database/';

		// ��ѯ���ؽ�����鲻������������
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

		// ���ݿ�־�����
		if (!$this->Config['db']['pconnect'])
		{
			define('ADODB_NEVER_PERSIST', TRUE);
		}

		// �������ݿ�
		$this->DB = &ADONewConnection('mysql');
		$this->DB->debug = $this->Config['debug'];
		$this->DB->PConnect($this->Config['db']['host'], $this->Config['db']['user'], $this->Config['db']['password'], $this->Config['db']['name']);

		$sql_version = $this->DB->ServerInfo();

		if ('4.1' < $sql_version['version'])
		{
			$this->DB->Execute('SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary');
			//$this->DB->Execute('SET NAMES utf8');

			if ('5.0' < $sql_version['version'])
			{
				$this->DB->Execute("SET sql_mode=''");
			}
		}

		$this->Config['db']['host'] = $this->Config['db']['user'] = $this->Config['db']['password'] = '';

		$error_msg = $this->DB->ErrorMsg();
		if ('' != $error_msg) die($error_msg);
	}


	/**
	 *
	 * ��ʼ��ģ������
	 *
	 */
	public function InitTemplate($tpl_dir, $caching = TRUE, $cache_time = 600)
	{
		// Smartyģ��
		require_once(ROOT_PATH.'/include/library/smarty/Smarty.class.php');

		$this->tpl = new Smarty();

		// ������Ϣ
		$this->tpl->debugging = FALSE;

		$this->tpl->left_delimiter = '<!--{';
		$this->tpl->right_delimiter = '}-->';

		// ��������ļ�����Ŀ¼
		$this->SetTemplateDir($tpl_dir);

		// �Ƿ�رձ���(FALSE�ر�)
		$this->tpl->compile_check   = $this->Config['tpl_compile'] ? TRUE : FALSE;

		// �Ƿ�ʹ�û���
		if (!defined('NOT_USE_CACHE') && $this->Config['tpl_cache'])
		{
			$this->tpl->caching = TRUE;

			if (!defined('CACHE_PLACE')) define('CACHE_PLACE', 'list');

			$this->tpl->cache_lifetime  = $this->Config['tpl_cache_time_'.CACHE_PLACE];
			if (60 > $this->tpl->cache_lifetime)
			{
				$this->tpl->caching = FALSE;
			}
		}
	}

	public function SetTemplateDir($tpl_dir)
	{
		$this->tpl->template_dir = $this->Config['dir']['data'].'/template/'.$tpl_dir;
		$this->tpl->compile_dir  = $this->Config['dir']['data'].'/template_c/'.$tpl_dir;
		$this->tpl->cache_dir    = $this->Config['dir']['data'].'/cache/template/';

		// ��ʼ�����԰�
		$this->LanguageInit();
	}


	/**
	 *
	 * ��黺���ļ��Ƿ���Ч
	 *
	 */
	public function CheckCache($tpl_name, $sub_dir, $cache_only_key)
	{
		if (TRUE !== $this->tpl->caching) return;

		$cache_only_key = md5($cache_only_key);

		// �����洢��Ŀ¼
		$sub_dir .= '/'.substr($cache_only_key, 0, 2);
		$sub_dir .= '/'.substr($cache_only_key, 2, 1);
		$this->CreateSubDir($this->tpl->cache_dir, $sub_dir);
		$this->tpl->cache_dir .= $sub_dir;

		//$this->tpl->compile_id = $cache_only_key;

		if ($this->tpl->is_cached($tpl_name))
		{
			$this->tpl->display($tpl_name, $cache_only_key);
			exit;
		}

		return $cache_only_key;
	}


	/**
	 *
	 * ��������ļ�
	 *
	 */
	public function ClearCache($tpl_name, $sub_dir, $cache_only_key)
	{
		$cache_only_key = md5($cache_only_key);
		$this->tpl->cache_dir .= '/'.substr($cache_only_key, 0, 2);
		$this->tpl->cache_dir .= '/'.substr($cache_only_key, 2, 1);

		$this->tpl->clear_cache($tpl_name);
		//$this->tpl->clear_cache($tpl_name, $cache_only_key);
	}


	/**
	 *
	 * ����û����Ϸ���
	 * ����,��ĸ,�»���(_)
	 *
	 */
	public function UserNameCheck($name)
	{
		// ����ʹ����Ӣ�����ֺ�_(�»���)
		return !preg_match('#[\x20-\x2F\x3A-\x40\x5B-\x5E\x60\x7B-\x7E]#', $name);
	}


	/**
	 *
	 * ���ܵ�ַ����
	 *
	 */
	public function UrlEncryptParame($id, $date)
	{
		return bin2hex(date('Y|md', $date).'|'.$id);
	}


	/**
	 *
	 * �ַ�������
	 *
	 */
	public function CryptPW($password)
	{
		return md5($password);
	}


	/**
	 *
	 * ȡ�û�����
	 *
	 */
	public function GetUserInfo($user_id)
	{
		$user_id = intval($user_id);
		if (0 < $user_id )
		{
			$this->UserInfo = $this->DB->GetRow("SELECT * FROM {$this->TablePre}user WHERE user_id='{$user_id}'");
			$this->UserInfo['vip'] = 1;
		}
	}

	/**
	 *
	 * ���������ؼ���
	 *
	 */
	public function KeywordTop($force = 0)
	{
		if (0 >= $this->Config['search_top_num'])
		{
			return '';
		}

		$keyword_cache_file = $this->Config['dir']['data'].'/cache/hot_keyword.php';
		if (file_exists($keyword_cache_file))
		{
			include_once($keyword_cache_file);
		}

		// ǿ�Ƹ���
		if (1 == $force) $cache_day = 0;

		$current_day = date('Ymd', TIME_NOW);
		if ($current_day != $cache_day)
		{
			// �ؽ�����
			$new_hot_keyword = array();
			$query_hot_keyword = $this->DB->Execute("SELECT * FROM {$this->TablePre}search_keyword ORDER BY search_num DESC LIMIT {$this->Config['search_top_num']}");
			$new_rank = 1;
			while (!$query_hot_keyword->EOF)
			{
				$new_hot_keyword['keyword'][$new_rank] = $query_hot_keyword->fields['search_keyword'];
				if (is_array($hot_keyword['keyword']))
				{
					$old_rank = array_search($new_hot_keyword['keyword'][$new_rank], $hot_keyword['keyword']);
				}
				else
				{
					$old_rank = FALSE;
				}
				if (FALSE === $old_rank)
				{
					// ���ϰ�
					$new_hot_keyword['state'][$new_rank] = 'new';
				}
				else
				{
					if ($new_rank > $old_rank)
					{
						// ��
						$new_hot_keyword['state'][$new_rank] = 'drop';
					}
					else if ($new_rank < $old_rank)
					{
						// ��
						$new_hot_keyword['state'][$new_rank] = 'rise';
					}
					else
					{
						// ƽ
						$new_hot_keyword['state'][$new_rank] = 'even';
					}
				}
				$new_rank++;
				$query_hot_keyword->MoveNext();
			}

			$hot_keyword = $new_hot_keyword;
			unset($new_hot_keyword);

			$cache_info  = '$cache_day = \''.$current_day.'\';';
			$cache_info .= "\r\n";
			$cache_info .= '$hot_keyword = '.var_export($hot_keyword, TRUE).';';

			$this->UpdateCacheFile($keyword_cache_file, $cache_info);
		}
		$keyword_list = '';
		if ($hot_keyword)
		{
			foreach ($hot_keyword['keyword'] as $key=>$h_keyword)
			{
				$keyword_list .= '<a href="'.$this->Config['domain_search'].'/?keyword='.urlencode($h_keyword).'">'.$h_keyword.'</a>';
				switch ($hot_keyword['state'][$key])
				{
					case 'new':
						$keyword_list .= '<span class="s_new">(New)</span>';
					break;
					case 'drop':
						$keyword_list .= '<span class="s_drop">&#8595;</span>';
					break;
					case 'rise':
						$keyword_list .= '<span class="s_rise">&#8593;</span>';
					break;
					default:
						$keyword_list .= '';
					break;
				}
				$keyword_list .= '&nbsp;';
			}
		}

		return $keyword_list;
	}


	/**
	 *
	 * COOKIE����
	 *
	 */
	public function MySetcookie($name, $value = '', $expire = 0, $domain = '')
    {
		if (0 != $expire)
		{
			$expires = TIME_NOW + $expire;
		}

		//$this->Config['cookie']['domain'] = $this->Config['cookie']['domain'] == '' ? ''  : '.'.$this->Config['site_domain'];
		//$this->Config['cookie']['path']   = $this->Config['cookie']['path']   == '' ? '/' : $this->Config['cookie']['path'];

		if (!empty($domain)) $domain = '.'.$domain;

		setcookie($name, $value, $expires, '/', $domain);
		//@setcookie($name, $value, $expires, '/');
	}


	/**
	 *
	 * �Զ����ַ�������ͳ�Ʒ���
	 *
	 */
	public function CnStrlen($string)
	{
		if ('' == $string) return 0;

		// ��utf-8������,Ĭ��һ������Ϊ�����ַ�
		// ���,ǿ�ƽ�һ������ͳ��Ϊ�����ַ�
		$string = preg_replace('#[^\x20-\x7f]{2,3}#i', '00', $string);

		//iconv_strlen($string, 'utf-8');

		return strlen($string);
	}


	/**
	 *
	 * �����֤��
	 *
	 */
	public function CheckVerifyCode($name, $value)
	{
		// �ѹر�����֤�빦��
		if ($this->Config['verify_code_close']) return TRUE;

		$value = trim($value);
		if ('' == $value)
		{
			$this->Notice($this->Language['common']['no_vcode'], 'back');
		}
		if ($_COOKIE[$name] != md5(strtolower($value)))
		{
			$this->Notice($this->Language['common']['vcode_error'], 'back');
		}
	}


	/**
	 *
	 * ������֤��
	 *
	 */
	public function DestructVerifyCode($name)
	{
		if (isset($_COOKIE[$name]))
		{
			$this->MySetcookie($name, 0);
		}
	}


	/**
	 *
	 * �滻ͼƬ��Ϣ
	 *
	 */
	public function ReplaceImageInfo($content)
	{
		$content = str_ireplace(
			array('#PIC_ALT#', '#PIC_URL#'), 
			array($this->Config['upic_title'], $this->Config['upic_url']), 
			$content
		);
		return $content;
	}


	/**
	 *
	 * ����ַ������Ƿ���������ַ�
	 *
	 */
	public function CheckBadword($str)
	{
		$str = trim($str);
		if (empty($str)) return TRUE;

		$badword = $this->DB->CacheGetAll(18000, "SELECT * FROM {$this->TablePre}badword ORDER BY badword_id DESC");
		if ($badword)
		{
			$words = array();
			foreach ($badword as $key=>$row)
			{
				$words[] = preg_quote($row['badword_name']);
			}
			if ($words)
			{
				$word_str = implode('|', $words);
				if (preg_match('#'.$word_str.'#i', $str, $matchs))
				{
					return $matchs[0];
				}
			}
			unset($words);
		}

		return TRUE;
	}


	/**
	 *
	 * ��ȡ�ÿ���ʵIP
	 * �����ȡʧ�������ʾ��Ϣ,������ֹ����
	 *
	 */
	public function GetClientIP()
	{
		if ($_SERVER['HTTP_X_FORWARDED_FOR'])
		{
			$clientip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else if ($_SERVER['HTTP_CLIENT_IP'])
		{
			$clientip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else
		{
			$clientip = $_SERVER['REMOTE_ADDR'];
		}

		if (!preg_match('/^(\d{1,3}\.){3}\d{1,3}$/', $clientip))
		{
			$clientip = 'unknown';
		}

		define('CLIENT_IP', $clientip);
	}


	/**
	 *
	 * ����һ������ַ���
	 *
	 */
	public function RandStr($length = 4, $bound = '')
	{
		switch ($bound)
		{
			// ����
			case 'numeric':
				$character = '0123456789';
				$character_length = 10;
			break;
			// ��ĸ
			case 'letter':
				$character = 'abcdefghijklmnopqrstuvwxyz';
				$character_length = 26;
			break;
			// ��ĸ������
			default:
				$character = '45679acefhjkmnprstwxy';
				$character_length = 21;
			break;
		}

		$str = '';
		for ($i = 0; $i < $length; $i++)
		{
			$num = mt_rand(0, $character_length - 1);
			$str .= $character{$num};
		}

		return $str;
	}


	/**
	 *
	 * ��ǰҳ�����һҳ���ַ
	 *
	 */
	public function GetReferrerUrl()
	{
		$temp_url = $_REQUEST['url'];

		$scriptpath = CURRENT_URL;

		if (empty($temp_url))
		{
			$url = $_SERVER['HTTP_REFERER'];
		}
		else
		{
			if ($temp_url == $_SERVER['HTTP_REFERER'])
			{
				$url = '/index.php';
			}
			else
			{
				$url = $temp_url;
			}
		}

		if ($url == $scriptpath || empty($url))
		{
			$url = '/index.php';
		}

		return urlencode($url);
	}


	/**
	 *
	 * ����Ŀ¼$dir: dir1/dir2/dir3 ...
	 *
	 *
	 */
	public function CreateSubDir($root, $dir)
	{
		$full_dir = $root;
		if (!empty($dir))
		{
			$_dir = explode('/', $dir);
			foreach ($_dir as $d)
			{
				$full_dir .= '/'.$d;
				if (!is_dir($full_dir))
				{
					if (!@mkdir($full_dir, 0777))
					{
						return FALSE;
					}
				}
			}
		}

		return $full_dir;
	}


	/**
	 *
	 * ɾ��һ��Ŀ¼
	 *
	 * ͬʱɾ����Ŀ¼�µ�������Ŀ¼���ļ�
	 *
	 */
	public function CustomRmdir($dir)
	{
		$result = FALSE;

		if(!is_dir($dir)) return $result;

		$handle = opendir($dir);
		while (FALSE !== ($file = readdir($handle)))
		{
			if ($file != '.' && $file != '..')
			{
				$current_dir = $dir . DIRECTORY_SEPARATOR . $file;
				is_dir($current_dir) ? $this->CustomRmdir($current_dir) : unlink($current_dir);
			}
		}
		closedir($handle);
		$result = rmdir($dir) ? TRUE : FALSE;

		return $result;
	}



	/**
	 *
	 * ��̨������־
	 *
	 */
	public function ManagerLog($action)
	{
		$manager_id = 0 < AdminUserID ? AdminUserID : $_SESSION['C_AdminUserID'];

		$this->DB->Execute("INSERT INTO {$this->TablePre}manager_log (manager_id, action, dateline, client_ip) VALUES ('".$manager_id."', '".htmlspecialchars($action)."', '".TIME_NOW."', '".CLIENT_IP."')");
	}


	/**
	 *
	 * ��Ϣ��ʾ
	 *
	 */
	public function Notice($msg, $action = '', $url = '', $time = 3)
	{
		if ('json' == $action) exit(json_encode($msg));

		if ('rss' == IN_SCRIPT)
		{
			exit('<?xml version="1.0" encoding="utf-8" ?><rss>'.$msg.'</rss>');
		}

		if (defined('IS_AJAX') || 'ajax' == IN_SCRIPT || 'cron' == IN_SCRIPT)
		{
			exit($msg);
		}

		switch ($action)
		{
			// ������һҳ
			case 'back':
				$content = $msg.'<br /><a href="javascript:self.history.back(1);"><span class="text_normal" style="font-size:12px;">['.$this->Language['common']['back'].']</span></a><meta http-equiv="Refresh" content="'.$time.'; URL=javascript:self.history.back(1);" />';
			break;

			// ��ת��ָ��ҳ��
			case 'goto':
				$content = $msg.'<meta http-equiv="Refresh" content="'.$time.'; URL='.$url.'" />';
			break;

			// JS�����Ի�����ʾ��Ϣ
			case 'js':
				die('<script type="text/javascript">alert("'.$msg.'");self.history.back(-1);</script>');
			break;

			// ֱ������ַ���
			case 'echo':
				die($msg);
			break;

			// ͣ�ڵ�ǰҳ
			case 'halt';
			default:
				$content = $msg;
			break;
		}

		if (defined('NOT_USE_TEMPLATE')) exit($content);

		$this->tpl->caching = FALSE;
		$this->tpl->assign(array(
			/*ҳ��title*/
			'SiteTitle' => $this->Language['common']['notice'].' - Notice',
			/*��ʾ����*/
			'Content'   => $content,
		));

		$template_name = 'notice.tpl';
		if ('user' == IN_PLACE)
		{
			$template_name = 'user/'.$template_name;
		}
		$this->tpl->display($template_name);
		exit;
	}


	/**
	 * ��ʮ����������ת���ɶ�����
	 *
	 * @access public
	 * @return string
	 */
	public function hex2bin($hexdata)
	{
		$bindata = '';
		$hexdata_length = strlen($hexdata);
		for ($i = 0; $i < $hexdata_length; $i += 2)
		{
			$bindata .= chr(hexdec(substr($hexdata, $i, 2)));
		}

		return $bindata;
	}


	/**
	 * ���»����ļ�
	 *
	 * @access public
	 * @return boolean
	 */
	public function UpdateCacheFile($filepath, $fileinfo)
	{
		$cache_info = "<?php\r\n";
		$cache_info .= "if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');\r\n";
		$cache_info .= "// Last Updated: ".date('H:i:s Y/m/d', TIME_NOW)."\r\n\r\n";
		$cache_info .= $fileinfo;
		$cache_info .= "\r\n\r\n?>";

		if ('5.1.0' <= PHP_VERSION)
		{
			return file_put_contents($filepath, $cache_info, LOCK_EX);
		}
		else
		{
			$handle = fopen($filepath, 'wb');
			flock($handle, LOCK_EX);
			fwrite($handle, $cache_info);
			flock($handle, LOCK_UN);
			fclose($handle);

			return TRUE;
		}
	}

	/**
	 * ȡ����ӵ����нڵ���Ϣ
	 * ���ָ����node_id����,�򷵻��������Ӧ�ĵ����ڵ���Ϣ
	 *
	 * @access public
	 * @return array
	 */
	public function LoginNode($node_id = 0)
	{
		$cache_file_path = $this->Config['dir']['data'].'/cache/login_node.php';
		if (file_exists($cache_file_path))
		{
			include_once($cache_file_path);
			if ($NodeInfo)
			{
				$NodeInfo = array_slice($NodeInfo, 0, $this->License['node'], TRUE);
			}
			if (0 < $node_id)
			{
				$NodeInfo = $NodeInfo[$node_id];
			}
		}

		return $NodeInfo;
	}


	/**
	 * ת�������ַ����еı���%sX
	 *
	 * ���տɱ����
	 *
	 * @access public
	 * @return string
	 */
	public function LangReplaceText()
	{
		$numargs = func_num_args();
		$arg_list = func_get_args();

		$language_text = $arg_list[0];

		for ($i = 1; $i < $numargs; $i++)
		{
			$language_text = str_ireplace('%s'.$i, $arg_list[$i], $language_text);
		}

		return $language_text;
	}


	/**
	 * �б��ҳ
	 *
	 * @access public
	 * @return array
	 */
	public function Multipage($totalnum, $page, $perpage, $pagetype = 'php', $request_uri = '', $c_sub_dir = '')
	{
		if (empty($c_sub_dir)) $c_sub_dir = TEMPLATE_SUB_DIR;

		require_once(ROOT_PATH.'/include/kernel/class_multipage_'.$c_sub_dir.'.php');
		$mpage = new Multipage($this, $totalnum, $page, $perpage);
		if ('html' == $pagetype)
		{
			$mpage->PageType = 'html';
		}
		if ('' != $request_uri)
		{
			$mpage->RequestURI = $request_uri;
		}

		return array(
			'offset'    => $mpage->Offset, 
			'totalpage' => $mpage->TotalPage, 
			'page'      => ('admin'==$c_sub_dir ? $mpage->PageInfo() : '').$mpage->ShowMultiPage(), 
		);
	}

	/**
	 * ���ݷ�ҳ
	 *
	 * @access public
	 * @return string
	 */
	public function ContentMultipage($id, $total, $page)
	{
		if (0 == $total) return '';

		if (0 >= $page)
		{
			$page_code = '<span class="nextprev">&laquo; '.$this->Language['multipage']['previous'].'</span>';
		}
		else
		{
			$previous_num = $page - 1;
			if (0 >= $previous_num) $previous_num = '';
			else $previous_num = '-'.$previous_num;
			$page_code = '<a href="'.$id.$previous_num.'.html" class="nextprev">&laquo; '.$this->Language['multipage']['previous'].'</a>';
		}

		// ��ҳ
		if (0 < ($page - 3) || 3 < $page)
		{
			$page_code .= '<a href="'.$id.'.html" class="pager-first active">1</a>';
		}

		// ѭ����ʼ��ֵ
		$loop_start_num = $page - 3;
		$loop_start_num = $loop_start_num < 0 ? 0 : $loop_start_num;
		// ѭ��������ֵ
		$loop_end_num = $page + 3;
		$loop_end_num = $loop_end_num > $total ? $total : $loop_end_num;

		$loop_page_num = '';
		if (1 < $page - 4) $page_code .= '<span>&#8230;.</span>';
		for ($pagenum = $loop_start_num; $pagenum <= $loop_end_num; $pagenum++)
		{
			if ($page == $pagenum)
			{
				$page_code .= '<span class="current">'.($pagenum+1).'</span>';
			}
			else
			{
				$page_code .= '<a href="'.$id.($pagenum?'-'.$pagenum:'').'.html">'.($pagenum+1).'</a>';
			}
		}
		if ($page < $total - 4) $page_code .= '<span>&#8230;.</span>';

		// ĩҳ
		if (3 < $total - $page || $total - 3 > $page)
		{
			$page_code .= '<a href="'.$id.'-'.$total.'.html" class="pager-last active" target="_self">'.($total+1).'</a>';
		}

		if ($total == $page)
		{
			$page_code .= '<span class="nextprev">'.$this->Language['multipage']['next'].' &raquo;</span>';
		}
		else
		{
			$next_num = $page + 1;
			$page_code .= '<a href="'.$id.'-'.$next_num.'.html" class="nextprev">'.$this->Language['multipage']['next'].' &raquo;</a>';
		}

		return $page_code;
	}


	/**
	 * ������Ӧ�������ļ�
	 *
	 * @access private
	 * @return void
	 */
	private function LanguageInit()
	{
		if ($this->Language) return;

		$language_file_path = $this->tpl->template_dir.DIRECTORY_SEPARATOR.'language.php';
		if (!file_exists($language_file_path))
		{
			die('<br /><b>Fatal error</b>:  Language file <b>'.$language_file_path.'</b> does not exist<br />');
		}

		// ��ǰʹ�õ�����
		//define('CURRENT_LANGUAGE', $current_language);

		include_once($language_file_path);

		$this->Language = $lang;
	}

	// ���ɾ�̬HTML
	public function CreateHtml($type, $sort = NULL)
	{
		static $create;

		if (!$type) return FALSE;

		if (!is_object($create))
		{
			if (!$sort)
			{
				require_once(ROOT_PATH.'/include/kernel/class_sort.php');
				$sort = new Sort($this->Config);
			}

			require_once(ROOT_PATH.'/include/kernel/class_html.php');
			$create = new Html($this, $sort);
		}

		$create->Create($type);
	}

	// ɾ����̬HTML
	public function DeleteHtml($id, $page_num)
	{
		static $create;

		if (!$id) return FALSE;

		if (!is_object($create))
		{
			require_once(ROOT_PATH.'/include/kernel/class_html.php');
			$create = new Html($this);
		}

		$create->delete_show($id, $page_num);
	}

	// ͳ�����ķ�ҳҳ��
	public function GetHtmlPageNum($content)
	{
		$page_break_str = addslashes('<div style="page-break-after: always"><span style="display: none">&nbsp;</span></div>');
		return substr_count($content, $page_break_str);
	}


	// �����������:����&����
	public function SpecialSortData()
	{
		$sort_id = $this->Config['announcement_sort_id'];

		if (!$sort_id) return array();

		$condition = 'is_auditing=1 AND mark_deleted=0';
		$child_sort = $this->sort->GetChild($sort_id);
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

		$query = $this->DB->CacheExecute(600, "SELECT * FROM {$this->TablePre}data WHERE {$condition} ORDER BY data_id DESC LIMIT 5");
		$data = array();
		$key = 0;
		while (!$query->EOF)
		{
			$data[$key] = $query->fields;

			// ������
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
			//if (IS_VIP || $this->sort->SortList[$query->fields['sort_id']]['vip'])
			if (IS_VIP)
			{
				$data[$key]['show_url'] = $this->Config['domain_vip'].'/show-'.$data[$key]['hash_id'].'.html';
			}
			else
			{
				$data[$key]['show_url'] = $this->Config['domain_www'].'/go.html?p='.$this->UrlEncryptParame($data[$key]['data_id'], $data[$key]['release_date']);
				//$data[$key]['show_url'] = $this->Config['domain_www'].'/show/'.date('Y/md', $data[$key]['release_date']).'/'.$data[$key]['data_id'].'.html';
			}
			$key++;
			$query->MoveNext();
		}

		return $data;
	}

	// ��鼤����֤IP��
	public function IPValidateCheck($user_id = 0)
	{
		if (0 >= $this->Config['validate_ip']) return TRUE;

		if ($this->UserInfo['validate_ip'] >= $this->Config['validate_ip']) return TRUE;

		$this->tpl->caching = FALSE;
		$this->tpl->assign(array(
			/*ҳ��title*/
			'SiteTitle' => $this->Language['common']['notice'].' - Notice',
			'UserID'    => $user_id,
		));
		$this->tpl->display('user/validate_ip_notice.tpl');
		exit;
	}

	// �ʼ�����
	public function SendMail($is_html, $email, $username, $subject, $body)
	{
		if (empty($email) || empty($subject) || empty($body)) return;

		static $send;

		if (!is_object($send))
		{
			require_once(ROOT_PATH.'/include/library/phpmailer/class.phpmailer.php');
			$send = new PHPMailer();
			$send->CharSet = 'utf-8';
			//$send->SMTPDebug = TRUE;

			$send->IsSMTP();
			$send->SMTPAuth = TRUE;

			$send->IsHTML($is_html);

			$send->Host = $this->Config['smtp_host'];
			$send->Port = $this->Config['smtp_port'];
			$send->Username = $this->Config['smtp_user'];
			$send->Password = $this->Config['smtp_password'];

			$send->From     = $this->Config['smtp_user'];
			$send->FromName = $this->Config['site_name'];
		}

		$send->Subject = $subject;
		$send->Body = $body;
		$send->Body = eregi_replace("[\]", '', $send->Body);
		$send->AddAddress($email, $username);
		$send->Send();
	}
}
?>