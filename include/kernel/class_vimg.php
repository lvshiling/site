<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class VerifyImage
{
	/******* ������Ա���� *******/

	/**
	 * ͼ�������ʽ
	 *
	 * @var string
	 * @access public
	 */
	public $OutFormat = 'png';

	/*
	* ������ɫ
	*
	* @var array
	* @access public
	*/
	public $TxtColors = array();

	/**
	 * ͼ��߿���ɫ
	 *
	 * @var string
	 * @access public
	 */
	public $BorderColor = '000000';

	/**
	 * ͼ���������ɫ
	 *
	 * @var string
	 * @access public
	 */
	public $DColor = '000000';

	/**
	 * ͼ�񱳾���ɫ
	 *
	 * @var string
	 * @access public
	 */
	public $ImgBgColor = 'FFFFFF';

	/**
	 * ����
	 *
	 * @var string
	 * @access public
	 */
	public $TxtFont;

	/**
	 * ���ִ�С,��λpt
	 *
	 * @var string
	 * @access public
	 */
	public $FontSize = 9;

	/**
	 * ����ʹ�õ��ַ�������
	 *
	 * @var integer
	 * @access private
	 */
	//public $CharSet = 'utf-8';


	/******* ˽�г�Ա���� *******/

	/**
	 * ͼƬ�ϵ�����
	 *
	 * @var string
	 * @access private
	 */
	private $TxtStr;

	/**
	 * ������ɫ
	 *
	 * @var string
	 * @access private
	 */
	private $TxtColor;

	/**
	 * �������ַ���λ��.��,������
	 *
	 * @var integer
	 * @access private
	 */
	private $TextPositionX;
	private $TextPositionY;

	/**
	 * ͼ����ԴID, ���ڴ���ͼ��
	 *
	 * @var integer
	 * @access private
	 */
	private $ResourceImage;



	/**
	 * ���캯��
	 *
	 * @access public
	 * @param string $string
	 * @return void
	 */
	public function __construct($string)
	{
		if (!extension_loaded('gd'))
		{
			die("skip gd extension not available");
		}

		$this->TxtStr = $string;
	}

	/**
	 * ��������ֵ
	 *
	 * ����������ͼ���ϵ�����ֵ
	 *
	 * @access private
	 * @param integer $x
	 * @param integer $y
	 * @return void
	 */
	public function SetTextPosition($x, $y)
	{
		$this->TextPositionX = &$x;
		$this->TextPositionY = &$y;
	}

	/**
	 * ���������ͼ��
	 *
	 * ���������һ��ͼ��
	 *
	 * @access private
	 * @param integer $width
	 * @param integer $heigth
	 * @return void
	 */
	public function CreateImg($width, $height)
	{
		$this->ImgWidth = &$width;
		$this->ImgHeight = &$height;

		if (!file_exists($this->TxtFont))
		{
			echo '<br /><b>Fatal error:</b> could not find the font <b>'.$this->TxtFont.'</b>';
			exit;
		}

		// �½�һ�����ڵ�ɫ���ͼ��
		$this->ResourceImage = imagecreate($this->ImgWidth, $this->ImgHeight);

		// ����ͼ�񱳾�
		$this->DrawImgBg();

		// ������ɫ
		$this->TxtColor = $this->TxtColors[mt_rand(0, (count($this->TxtColors)-1))];

		// ��ͼ����д��
		// ͼ����Դ,���ִ�С,��,xλ��,yλ��,������ɫ,����,����
		imagettftext($this->ResourceImage, $this->FontSize, 0, $this->TextPositionX, $this->TextPositionY, $this->GetRGBColor($this->TxtColor), $this->TxtFont, $this->TxtStr);

		// ���
		$this->OutputImg();
	}

	/**
	 * ���ͼ��
	 *
	 * ���ͼ�������
	 *
	 * @access private
	 * @return void
	 */
	private function OutputImg()
	{
		header('Cache-Control: no-cache, must-revalidate');
		header('Pragma: no-cache');
		header("Content-Type: image/".$this->OutFormat."");
		switch ($this->OutFormat)
		{
			case 'gif':
				imagegif($this->ResourceImage);
			break;
			case 'jpeg':
				imagejpeg($this->ResourceImage);
			break;
			default:
				imagepng($this->ResourceImage);
			break;
		}

		imagedestroy($this->ResourceImage);
	}

	/**
	 * �������ű���
	 *
	 * ��ͼ���ϴ������ű���
	 *
	 * @access private
	 * @return boolean
	 */
	private function DrawImgBg()
	{
		// ��ͼ���ϱ�����ɫ
		$this->GetRGBColor($this->ImgBgColor);

		// ���ŵ���ɫ
		$spot_color = $this->GetRGBColor($this->DColor);

		// ���Ƹ��ŵ�
		for ($i = 0; $i < ($this->ImgWidth + $this->ImgHeight); $i++)
		{
			imagesetpixel($this->ResourceImage, mt_rand(0, $this->ImgWidth), mt_rand(0, $this->ImgHeight), $spot_color);
		}

		// ��ͼ�񻭱߿�
		if ('' != $this->BorderColor)
		{
			imagerectangle($this->ResourceImage, 0, 0, $this->ImgWidth-1, $this->ImgHeight-1, $this->GetRGBColor($this->BorderColor));
		}

		return TRUE;
	}

	/**
	 * ȡ����ɫRGBֵ
	 *
	 * ȡ����ɫRGBֵ
	 *
	 * @access private
	 * @param string $color
	 * @return resource
	 */
	private function GetRGBColor($color)
	{
		sscanf($color, "%2x%2x%2x", $red, $green, $blue);
		return imagecolorallocate($this->ResourceImage, $red, $green, $blue);
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