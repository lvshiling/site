<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class Login
{
	// 核心对象
	private $core;

	// 用户ID
	private $UserID = 0;

	// 用户名
	private $UserName;

	// 用户密码
	private $Password;


	public function __construct($core)
	{
		$this->core = $core;
	}


	// 登录
	public function Execute($username, $password)
	{
		$this->UserName = trim($username);
		$this->Password = $password;
		$login_node = intval($login_node);

		if (empty($this->UserName))
		{
			$this->core->Notice($this->core->Language['login']['error_user_empty'], 'back');
		}
		if (empty($this->Password))
		{
			$this->core->Notice($this->core->Language['login']['error_password_empty'], 'back');
		}

		$password_ = $this->core->CryptPW($this->Password);

		$user_info = $this->core->DB->GetRow("SELECT user_id, user_password, validate_email FROM {$this->core->TablePre}user WHERE user_name='{$this->UserName}'");
		if ($user_info)
		{
			if ($user_info['user_password'] != $password_)
			{
				$this->core->Notice($this->core->Language['login']['error_password'], 'back');
			}
			if (!$user_info['validate_email'] && $this->core->Config['user_register_vemail'])
			{
				$this->core->Notice($this->core->Language['login']['error_no_validate_email'], 'back');
			}
			$this->UserID = $user_info['user_id'];
		}
		else
		{
			$this->core->Notice($this->core->LangReplaceText($this->core->Language['login']['error_user_not_exist'], $this->UserName), 'back');
		}

		$this->core->MySetcookie('XX_UserID', $this->UserID, intval($_POST['cookietime']), $this->core->Config['site_domain']);
	}


	// 发送Email验证邮件
	public function SendValidateEmail($email)
	{
		$key = md5('xx+-!'.$email);
		$key = base64_encode($key.'||'.$email);
		$validate_url = $this->core->Config['domain_vip'].'/user.php?o=validate_email&key='.$key;

		$mail_subject = $this->core->LangReplaceText($this->core->Language['validate_email']['mail_subject'], $this->core->Config['site_name']);
		$mail_body = file_get_contents(ROOT_PATH.'/include/reg_validate.mail');
		$mail_body = str_replace(
			array('{#SITE_NAME#}', '{#VALIDATE_URL#}'), 
			array($this->core->Config['site_name'], $validate_url), 
			$mail_body
		);

		$this->core->SendMail(FALSE, $email, '', $mail_subject, $mail_body);
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