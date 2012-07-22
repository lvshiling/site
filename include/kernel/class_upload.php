<?php
if (!defined('IN_SITE'))
{
	@header('HTTP/1.1 404 Not Found');exit;
}

error_reporting(E_ALL);

// �ļ��ϴ�(FTP)
//$up = new Upload($core);
//$up->CheckUpload();
//$up->Put();
final class Upload
{
	public $visit_path;

	private $use_gd = TRUE;

	private $core;
	private $ftp;
	private $up_file;
	//private $up_tmp_dir = ROOT_PATH.'/datacommon/up_tmp';

	public function __construct($core)
	{
		$this->core = $core;
	}

	// ����ϴ�
	public function Execute()
	{
		if ($_FILES)
		{
			if (!$this->CheckUpStatus($_FILES['error'])) continue;
			if ($this->core->Config['pic_file_size'] < $_FILES['size'])
			{
				// �ϴ��а��������涨��С��ͼƬ
				$this->core->Notice(array(
					'state' => 'error', 
					'value' => $this->core->Language['content']['error_upload_size'],
				), 'json');
			}

			//$this->up_file['name'] = $_FILES['name'];
			//$this->up_file['type'] = $_FILES['type'];
			$this->up_file['local'] = $_FILES['tmp_name'];
			//$this->up_file['error'] = $_FILES['error'];
			//$this->up_file['size'] = $_FILES['size'];
			$pic_info = getimagesize($this->up_file['local']);
			$this->up_file['postfix'] = $this->GetFilePostfix($pic_info['mime']);
			$this->up_file['remote'] = base64_encode(date('His', TIME_NOW).'-'.$this->core->RandStr(6)).'.'.$this->up_file['postfix'];

			if ($this->up_file['local'])
			{
				$this->LoginFtp();
				$this->CheckDir();
				$this->Put();
				ftp_close($this->ftp);
			}
		}

		return $this->up_file;
	}

	// ��¼FTP
	private function LoginFtp()
	{
		$ftpinfo = $this->core->DB->GetRow("SELECT * FROM {$this->core->TablePre}ftp_setting ORDER BY RAND() LIMIT 1");
		if (!$ftpinfo['ftp_host'])
		{
			// ϵͳ�ϴ��������ô���
			$this->core->Notice(array(
				'state' => 'error', 
				'value' => $this->core->Language['content']['error_ftp_setting'],
			), 'json');
		}

		$this->visit_path = $ftpinfo['visit_path'];

		$ftpinfo['ftp_port'] || $ftpinfo['ftp_port'] = 21;

		// ���ӷ�����
		$this->ftp = ftp_connect($ftpinfo['ftp_host'], $ftpinfo['ftp_port']);
		if (!$this->ftp)
		{
			$this->core->Notice(array(
				'state' => 'error', 
				'value' => $this->core->Language['content']['error_ftp_connect_failure'],
			), 'json');
		}
		// ��¼������
		if (!ftp_login($this->ftp, $ftpinfo['ftp_username'], $ftpinfo['ftp_password']))
		{
			$this->core->Notice(array(
				'state' => 'error', 
				'value' => $this->core->Language['content']['error_ftp_login_failure'],
			), 'json');
		}
		ftp_pasv($this->ftp, TRUE);
	}

	// �ϴ��ļ�
	private function Put()
	{
		if ($this->up_file)
		{
			$this->Quality($this->up_file['local']);
			ftp_put($this->ftp, $this->up_file['remote'], $this->up_file['local'], FTP_BINARY);
		}

		//return $this->up_file;
	}

	// ˮӡ
	// ���ˮӡͼƬ��ͼƬ�����½�
	private function Quality($pic_file)
	{
		if (!$this->core->Config['watermark']) return TRUE;

		if ($this->use_gd) $this->watermark_gd($pic_file);
		else $this->watermark_im($pic_file);
	}

	// ʹ��IM���ˮӡ
	private function watermark_im($pic_file)
	{
		$pic_info = getimagesize($pic_file);

		if (0 < $this->core->Config['pic_auto_modify'] && $this->core->Config['pic_auto_modify'] < $pic_info[0])
		{
			shell_exec($this->core->Config['imagick_path'].'convert -quality 75 '.$pic_file.' -resize 720 '.$pic_file);
		}

		$watermark_file = ROOT_PATH.'/include/watermark.png';

		if (!file_exists($watermark_file)) return TRUE;

		if (400 > $pic_info[0] || 300 > $pic_info[1]) return TRUE;

		$cmd = $this->core->Config['imagick_path'].'composite -gravity southeast '.$watermark_file.' '.$pic_file.' '.$pic_file;
		shell_exec($cmd);
	}

	// ʹ��GD���ˮӡ
	private function watermark_gd($pic_file)
	{
		$pic_info = getimagesize($pic_file);

		if (400 > $pic_info[0] || 300 > $pic_info[1]) return TRUE;

		if (800 > $pic_info[0] || 600 > $pic_info[1])
		{
			$watermark_file = ROOT_PATH.'/include/watermark_small.png';
		}
		else
		{
			$watermark_file = ROOT_PATH.'/include/watermark_big.png';
		}

		if (!file_exists($watermark_file)) return TRUE;

		$wm_info = getimagesize($watermark_file);

		$x = $pic_info[0] - $wm_info[0];
		$y = $pic_info[1] - $wm_info[1];

		$postfix = $this->GetFilePostfix($pic_info['mime']);
		$imagecreatefunc = $postfix=='gif' ? 'imagecreatefromgif' : ($postfix=='png' ? 'imagecreatefrompng' : 'imagecreatefromjpeg');
		$imagefunc = $postfix=='gif' ? 'imagegif' : ($postfix=='png' ? 'imagepng' : 'imagejpeg');

		$im = $imagecreatefunc($pic_file);
		$wm = imagecreatefrompng($watermark_file);

		$dst_pic = imagecreatetruecolor($pic_info[0], $pic_info[1]);

		imagecopy($dst_pic, $im, 0, 0, 0, 0, $pic_info[0], $pic_info[1]);
		imagecopy($dst_pic, $wm, $x, $y, 0, 0, $wm_info[0], $wm_info[1]);
		clearstatcache();

		$imagefunc($dst_pic, $pic_file);
	}

	// �����ļ�����
	// ����ļ���ʵ��׺
	private function GetFilePostfix($type)
	{
		switch ($type)
		{
			case 'image/gif':
				return 'gif';
			break;
			case 'image/png':
			case 'image/x-png':
				return 'png';
			break;
			//case 'image/bmp':
			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
				return 'jpg';
			break;
			default:
				// �ϴ��ļ��а����������ϴ����ļ�����
				$this->core->Notice(array(
					'state' => 'error', 
					'value' => $this->core->Language['content']['error_upload_filetype'],
				), 'json');
			break;
		}
	}

	// ����ϴ�������Ϣ
	private function CheckUpStatus($error)
	{
		switch ($error)
		{
			// 1 UPLOAD_ERR_INI_SIZE
			case 1:
			// 2 UPLOAD_ERR_FORM_SIZE
			case 2:
			// 3 UPLOAD_ERR_PARTIAL
			case 3:
			// 6 UPLOAD_ERR_NO_TMP_DIR
			case 6:
			// 7 UPLOAD_ERR_CANT_WRITE
			case 7:
				$this->core->Notice(array(
					'state' => 'error', 
					'value' => $this->core->Language['content']['error_upload_'.$error],
				), 'json');
			break;
			// UPLOAD_ERR_OK
			case 0:
				return TRUE;
			break;
			// UPLOAD_ERR_NO_FILE
			case 4:
				// û���ļ����ϴ�
				return FALSE;
			break;
			default:
				return FALSE;
			break;
		}
	}

	// ���Ŀ¼������
	private function CheckDir()
	{
		$sub_dir = date('Y/m/d', TIME_NOW);
		$this->visit_path .= '/'.$sub_dir;

		$_sub_dirs = explode('/', $sub_dir);
		foreach ($_sub_dirs as $dir)
		{
			if (@ftp_chdir($this->ftp, $dir)) continue;

			if (!@ftp_mkdir($this->ftp, $dir))
			{
				// �洢Ŀ¼����ʧ��
				$this->core->Notice(array(
					'state' => 'error', 
					'value' => $this->core->Language['content']['error_upload_dircreate'],
				), 'json');
			}
			@ftp_chdir($this->ftp, $dir);
		}

		// �л�����Ŀ¼
		//ftp_chdir($this->ftp, $_sub_dir);
	}

	public function __destruct()
	{
	}
}
?>