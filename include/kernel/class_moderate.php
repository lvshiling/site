<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class Moderate
{
	public $AdminManage = FALSE;

	// ���Ķ���
	private $core;

	private $OperateID;
	private $OperateData;


	public function __construct($core)
	{
		$this->core = $core;
	}

	/*
	 * ִ�в���
	 */
	public function Execute()
	{
		$operate = trim($_POST['operate']);

		// �˴�ֻ��ԷǺ�̨����Ա���Ȩ��
		if (FALSE == $this->AdminManage)
		{
			// �������Ƽ���Ȩ�����м��
			if ('heightlight' != $operate && 'commend' != $operate)
			{
				$this->checkPermission($operate);
			}
		}

		$this->getSelectData();

		$mod_ = $operate.'Data';
		$this->$mod_();
	}

	/*
	 * ȡ����Ч�Ĳ�������
	 */
	private function getSelectData()
	{
		$data_id_arr = $_POST['data_id'];
		if (!preg_match('#[1-9]+#', $data_id_arr[0]))
		{
			// û��ѡ����������
			$this->core->Notice($this->core->Language['data']['no_select'], 'back');
		}

		// ���˵�����������������
		$query_data = $this->core->DB->Execute("SELECT data_id, hash_id, user_id, sort_id, page_num, release_date, mark_deleted FROM {$this->core->TablePre}data WHERE data_id IN (".implode(',', $data_id_arr).")");
		if ($query_data)
		{
			$key = 0;
			while (!$query_data->EOF)
			{
				$current_data = $query_data->fields;
				$query_data->MoveNext();

				if (TRUE !== $this->AdminManage)
				{
					// �����Լ�����Դ
					if (FALSE == $this->AdminManage && $current_data['user_id'] != $this->core->UserInfo['user_id'])
					{
						continue;
					}
				}

				$this->OperateData[$key] = $current_data;
				$this->OperateID[] = $current_data['data_id'];

				$key++;
			}
		}

		if (!$this->OperateID)
		{
			// û��ѡ����������
			$this->core->Notice($this->core->Language['data']['no_select'], 'back');
		}
	}

	/*
	 * �������
	 */
	private function auditingData()
	{
		if (TRUE != $this->AdminManage) return;

		foreach ($this->OperateData as $data)
		{
			$this->core->DB->Execute("UPDATE {$this->core->TablePre}data SET is_auditing='1', mark_update='".TIME_NOW."' WHERE data_id='{$data['data_id']}'");
			if (!$this->core->sort->SortList[$data['sort_id']]['vip'])
			{
				$this->core->CreateHtml($data['data_id'], $this->core->sort);
			}
			else
			{
				$this->core->DeleteHtml($data['data_id'], $data['page_num']);
			}
		}
	}

	/*
	 * ɾ������
	 */
	private function deleteData()
	{
		foreach ($this->OperateData as $data)
		{
			//$this->core->DeleteHtml($data['data_id'], $data['page_num']);

			$this->core->DB->Execute("UPDATE {$this->core->TablePre}data SET mark_deleted=1 WHERE data_id='{$data['data_id']}'");
			//$this->core->DB->Execute("DELETE FROM {$this->core->TablePre}data_ext WHERE data_id='{$data['data_id']}'");
			//$this->core->DB->Execute("DELETE FROM {$this->core->TablePre}comment WHERE data_id='{$data['data_id']}'");
			//$this->core->DB->Execute("UPDATE {$this->core->TablePre}user SET post_totalnum=post_totalnum-1 WHERE user_id='{$data['user_id']}'");
		}

		if (TRUE == $this->AdminManage)
		{
			$this->core->ManagerLog($this->core->Language['data']['log_delete']);
		}
	}

	/*
	 * �Ƽ�/ȡ���Ƽ�����
	 * ���޺�̨����Ա
	 */
	private function commendData()
	{
		if (FALSE == $this->AdminManage)
		{
			// �ر������Ƽ�����
			$this->core->Notice($this->core->Language['data']['commend_close'], 'back');
		}

		$is_commend = $_POST['commend'] ? 1 : 0;

		$this->core->DB->Execute("UPDATE {$this->core->TablePre}data SET is_commend='{$is_commend}' WHERE data_id IN (".implode(',', $this->OperateID).")");

		foreach ($this->OperateID as $data_id)
		{
			$this->core->CreateHtml($data_id);
		}

		if (TRUE == $this->AdminManage)
		{
			$this->core->ManagerLog($this->core->Language['data']['log_commend_'.$is_commend]);
		}
	}

	/*
	 * ������Դ����
	 * ���޺�̨����Ա
	 */
	private function heightlightData()
	{
		if (FALSE == $this->AdminManage)
		{
			// �ر����˸������⹦��
			$this->core->Notice($this->core->Language['data']['heightlight_close'], 'back');
		}

		$style = $_POST['style'];

		// ����ɫ|�Ӵ�|��ɾ����|б��
		if ('' != $style['color'] || 0 != $style['bold'] || 0 != $style['strike'] || 0 != $style['italic'])
		{
			$title_style = array();
			// ����ɫ
			if ('' != $style['color']) $title_style[0] = $style['color'];
			else $title_style[0] = '';
			// �Ӵ�
			if (1 == $style['bold']) $title_style[1] = 1;
			else $title_style[1] = 0;
			// ��ɾ����
			if (1 == $style['strike']) $title_style[2] = 1;
			else $title_style[2] = 0;
			// б��
			if (1 == $style['italic']) $title_style[3] = 1;
			else $title_style[3] = 0;

			$title_style = implode('|', $title_style);
		}
		else
		{
			$title_style = '';
		}

		$this->core->DB->Execute("UPDATE {$this->core->TablePre}data SET title_style='{$title_style}' WHERE data_id IN (".implode(',', $this->OperateID).")");

		if (TRUE == $this->AdminManage)
		{
			$this->core->ManagerLog($this->core->Language['data']['log_heightlight']);
		}
	}

	/*
	 * �����Ӧ��Ȩ��
	 * ������̨����Ա
	 */
	private function checkPermission($operate)
	{
		// �û�����,�����Ӧ��Ȩ��
		require_once(ROOT_PATH.'/include/kernel/class_permission.php');
		$permission = new Permission($this->core);
		$permission->Check($operate, $this->core->UserInfo['user_id']);
	}

	// ����δ����ķ���
	public function __call($method, $arguments)
	{
		$this->core->Notice($this->core->Language['common']['p_error'], 'halt');
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