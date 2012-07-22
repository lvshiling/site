<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class Permission
{
	public $permission = TRUE;
	private $core;


	public function __construct($core)
	{
		$this->core = $core;
	}

	public function Check($operate, $user_id)
	{
		switch ($operate)
		{
			// 只针对发布种子
			case 'add':
				$operate_title = $this->core->Language['permission']['add'];
			break;
			case 'edit':
				$operate_title = $this->core->Language['permission']['edit'];
			break;
			case 'delete':
				$operate_title = $this->core->Language['permission']['delete'];
			break;
			default:
				$this->core->Notice($this->core->Language['common']['p_error'], 'back');
			break;
		}

		if ('add' != $operate)
		{
			// 不是自己发布的
			if ($user_id != $this->core->UserInfo['user_id'])
			{
				$this->permission = FALSE;
			}
		}
		// 没有设置为允许该项权限
		if (!$this->core->UserInfo['can_'.$operate])
		{
			$this->permission = FALSE;
		}

		if (FALSE == $this->permission)
		{
			$this->core->Notice($this->core->LangReplaceText($this->core->Language['permission']['no_permission'], $operate_title), 'back');
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