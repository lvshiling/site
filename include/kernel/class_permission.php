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
			// ֻ��Է�������
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
			// �����Լ�������
			if ($user_id != $this->core->UserInfo['user_id'])
			{
				$this->permission = FALSE;
			}
		}
		// û������Ϊ�������Ȩ��
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