<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

// 核心类
final class Core
{
	// 全局配置
	public $Config = array();

	// 用户资料
	public $UserInfo = array('user_id'=>0, 'user_name'=>'guest');

	// 数据库对象
	public $DB = NULL;

	// 语言包
	public $Language = array();

	// 模板
	public $tpl = NULL;

	// 数据库表前缀
	public $TablePre = 'xx_';


	/**
	 *
	 * 初始化数据库连接
	 *
	 */
	public function InitAdodb()
	{
		if ($this->DB) return;

		// 数据库表前缀
		$this->TablePre = $this->Config['db']['prefix'];

		// Adodb数据库操作类库
		require_once(ROOT_PATH.'/include/library/adodb/adodb.inc.php');

		// 查询缓存数据保存目录
		$ADODB_CACHE_DIR = $this->Config['dir']['data'].'/cache/database/';

		// 查询返回结果数组不包含数字主键
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

		// 数据库持久连接
		if (!$this->Config['db']['pconnect'])
		{
			define('ADODB_NEVER_PERSIST', TRUE);
		}

		// 连接数据库
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
	 * 初始化模板引擎
	 *
	 */
	public function InitTemplate($tpl_dir, $caching = TRUE, $cache_time = 600)
	{
		// Smarty模板
		require_once(ROOT_PATH.'/include/library/smarty/Smarty.class.php');

		$this->tpl = new Smarty();

		// 调查信息
		$this->tpl->debugging = FALSE;

		$this->tpl->left_delimiter = '<!--{';
		$this->tpl->right_delimiter = '}-->';

		// 设置相关文件保存目录
		$this->SetTemplateDir($tpl_dir);

		// 是否关闭编译(FALSE关闭)
		$this->tpl->compile_check   = $this->Config['tpl_compile'] ? TRUE : FALSE;

		// 是否使用缓存
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

		// 初始化语言包
		$this->LanguageInit();
	}


	/**
	 *
	 * 检查缓存文件是否有效
	 *
	 */
	public function CheckCache($tpl_name, $sub_dir, $cache_only_key)
	{
		if (TRUE !== $this->tpl->caching) return;

		$cache_only_key = md5($cache_only_key);

		// 创建存储子目录
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
	 * 清除缓存文件
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
	 * 检查用户名合法性
	 * 数字,字母,下划线(_)
	 *
	 */
	public function UserNameCheck($name)
	{
		// 允许使用中英文数字和_(下划线)
		return !preg_match('#[\x20-\x2F\x3A-\x40\x5B-\x5E\x60\x7B-\x7E]#', $name);
	}


	/**
	 *
	 * 加密地址参数
	 *
	 */
	public function UrlEncryptParame($id, $date)
	{
		return bin2hex(date('Y|md', $date).'|'.$id);
	}


	/**
	 *
	 * 字符串加密
	 *
	 */
	public function CryptPW($password)
	{
		return md5($password);
	}


	/**
	 *
	 * 取用户资料
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
	 * 热门搜索关键字
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

		// 强制更新
		if (1 == $force) $cache_day = 0;

		$current_day = date('Ymd', TIME_NOW);
		if ($current_day != $cache_day)
		{
			// 重建缓存
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
					// 新上榜
					$new_hot_keyword['state'][$new_rank] = 'new';
				}
				else
				{
					if ($new_rank > $old_rank)
					{
						// 降
						$new_hot_keyword['state'][$new_rank] = 'drop';
					}
					else if ($new_rank < $old_rank)
					{
						// 升
						$new_hot_keyword['state'][$new_rank] = 'rise';
					}
					else
					{
						// 平
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
	 * COOKIE设置
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
	 * 自定义字符串长度统计方法
	 *
	 */
	public function CnStrlen($string)
	{
		if ('' == $string) return 0;

		// 在utf-8编码下,默认一个中文为三个字符
		// 因此,强制将一个中文统计为二个字符
		$string = preg_replace('#[^\x20-\x7f]{2,3}#i', '00', $string);

		//iconv_strlen($string, 'utf-8');

		return strlen($string);
	}


	/**
	 *
	 * 检查验证码
	 *
	 */
	public function CheckVerifyCode($name, $value)
	{
		// 已关闭了验证码功能
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
	 * 销毁验证码
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
	 * 替换图片信息
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
	 * 检查字符串中是否包含敏感字符
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
	 * 获取访客真实IP
	 * 如果获取失败输出提示信息,程序中止运行
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
	 * 生成一组随机字符串
	 *
	 */
	public function RandStr($length = 4, $bound = '')
	{
		switch ($bound)
		{
			// 数字
			case 'numeric':
				$character = '0123456789';
				$character_length = 10;
			break;
			// 字母
			case 'letter':
				$character = 'abcdefghijklmnopqrstuvwxyz';
				$character_length = 26;
			break;
			// 字母加数字
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
	 * 当前页面的上一页面地址
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
	 * 创建目录$dir: dir1/dir2/dir3 ...
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
	 * 删除一个目录
	 *
	 * 同时删除该目录下的所有子目录和文件
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
	 * 后台管理日志
	 *
	 */
	public function ManagerLog($action)
	{
		$manager_id = 0 < AdminUserID ? AdminUserID : $_SESSION['C_AdminUserID'];

		$this->DB->Execute("INSERT INTO {$this->TablePre}manager_log (manager_id, action, dateline, client_ip) VALUES ('".$manager_id."', '".htmlspecialchars($action)."', '".TIME_NOW."', '".CLIENT_IP."')");
	}


	/**
	 *
	 * 消息提示
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
			// 返回上一页
			case 'back':
				$content = $msg.'<br /><a href="javascript:self.history.back(1);"><span class="text_normal" style="font-size:12px;">['.$this->Language['common']['back'].']</span></a><meta http-equiv="Refresh" content="'.$time.'; URL=javascript:self.history.back(1);" />';
			break;

			// 跳转到指定页面
			case 'goto':
				$content = $msg.'<meta http-equiv="Refresh" content="'.$time.'; URL='.$url.'" />';
			break;

			// JS弹出对话框提示信息
			case 'js':
				die('<script type="text/javascript">alert("'.$msg.'");self.history.back(-1);</script>');
			break;

			// 直接输出字符串
			case 'echo':
				die($msg);
			break;

			// 停在当前页
			case 'halt';
			default:
				$content = $msg;
			break;
		}

		if (defined('NOT_USE_TEMPLATE')) exit($content);

		$this->tpl->caching = FALSE;
		$this->tpl->assign(array(
			/*页面title*/
			'SiteTitle' => $this->Language['common']['notice'].' - Notice',
			/*显示内容*/
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
	 * 将十六进制数据转换成二进制
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
	 * 更新缓存文件
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
	 * 取得添加的所有节点信息
	 * 如果指定了node_id参数,则返回与参数对应的单个节点信息
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
	 * 转换语言字符串中的变量%sX
	 *
	 * 接收可变参数
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
	 * 列表分页
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
	 * 内容分页
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

		// 首页
		if (0 < ($page - 3) || 3 < $page)
		{
			$page_code .= '<a href="'.$id.'.html" class="pager-first active">1</a>';
		}

		// 循环开始数值
		$loop_start_num = $page - 3;
		$loop_start_num = $loop_start_num < 0 ? 0 : $loop_start_num;
		// 循环结束数值
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

		// 末页
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
	 * 引入相应的语言文件
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

		// 当前使用的语言
		//define('CURRENT_LANGUAGE', $current_language);

		include_once($language_file_path);

		$this->Language = $lang;
	}

	// 生成静态HTML
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

	// 删除静态HTML
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

	// 统计正文分页页数
	public function GetHtmlPageNum($content)
	{
		$page_break_str = addslashes('<div style="page-break-after: always"><span style="display: none">&nbsp;</span></div>');
		return substr_count($content, $page_break_str);
	}


	// 特殊分类数据:公告&帮助
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

	// 检查激活验证IP数
	public function IPValidateCheck($user_id = 0)
	{
		if (0 >= $this->Config['validate_ip']) return TRUE;

		if ($this->UserInfo['validate_ip'] >= $this->Config['validate_ip']) return TRUE;

		$this->tpl->caching = FALSE;
		$this->tpl->assign(array(
			/*页面title*/
			'SiteTitle' => $this->Language['common']['notice'].' - Notice',
			'UserID'    => $user_id,
		));
		$this->tpl->display('user/validate_ip_notice.tpl');
		exit;
	}

	// 邮件发送
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