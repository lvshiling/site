<?php
if (!defined('IN_SITE')) @header('HTTP/1.1  404  Not  Found');

final class VerifyImage
{
	/******* 公共成员变量 *******/

	/**
	 * 图像输出格式
	 *
	 * @var string
	 * @access public
	 */
	public $OutFormat = 'png';

	/*
	* 文字颜色
	*
	* @var array
	* @access public
	*/
	public $TxtColors = array();

	/**
	 * 图像边框颜色
	 *
	 * @var string
	 * @access public
	 */
	public $BorderColor = '000000';

	/**
	 * 图像干扰素颜色
	 *
	 * @var string
	 * @access public
	 */
	public $DColor = '000000';

	/**
	 * 图像背景颜色
	 *
	 * @var string
	 * @access public
	 */
	public $ImgBgColor = 'FFFFFF';

	/**
	 * 字体
	 *
	 * @var string
	 * @access public
	 */
	public $TxtFont;

	/**
	 * 文字大小,单位pt
	 *
	 * @var string
	 * @access public
	 */
	public $FontSize = 9;

	/**
	 * 文字使用的字符集编码
	 *
	 * @var integer
	 * @access private
	 */
	//public $CharSet = 'utf-8';


	/******* 私有成员变量 *******/

	/**
	 * 图片上的文字
	 *
	 * @var string
	 * @access private
	 */
	private $TxtStr;

	/**
	 * 文字颜色
	 *
	 * @var string
	 * @access private
	 */
	private $TxtColor;

	/**
	 * 设置文字放置位置.横,纵坐标
	 *
	 * @var integer
	 * @access private
	 */
	private $TextPositionX;
	private $TextPositionY;

	/**
	 * 图像资源ID, 用于创建图像
	 *
	 * @var integer
	 * @access private
	 */
	private $ResourceImage;



	/**
	 * 构造函数
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
	 * 设置坐标值
	 *
	 * 设置文字在图像上的坐标值
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
	 * 创建并输出图像
	 *
	 * 创建并输出一个图像
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

		// 新建一个基于调色板的图像
		$this->ResourceImage = imagecreate($this->ImgWidth, $this->ImgHeight);

		// 绘制图像背景
		$this->DrawImgBg();

		// 文字颜色
		$this->TxtColor = $this->TxtColors[mt_rand(0, (count($this->TxtColors)-1))];

		// 在图像上写字
		// 图像资源,文字大小,无,x位置,y位置,文字颜色,字体,文字
		imagettftext($this->ResourceImage, $this->FontSize, 0, $this->TextPositionX, $this->TextPositionY, $this->GetRGBColor($this->TxtColor), $this->TxtFont, $this->TxtStr);

		// 输出
		$this->OutputImg();
	}

	/**
	 * 输出图像
	 *
	 * 输出图像到浏览器
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
	 * 创建干扰背景
	 *
	 * 在图像上创建干扰背景
	 *
	 * @access private
	 * @return boolean
	 */
	private function DrawImgBg()
	{
		// 给图像上背景颜色
		$this->GetRGBColor($this->ImgBgColor);

		// 干扰点颜色
		$spot_color = $this->GetRGBColor($this->DColor);

		// 绘制干扰点
		for ($i = 0; $i < ($this->ImgWidth + $this->ImgHeight); $i++)
		{
			imagesetpixel($this->ResourceImage, mt_rand(0, $this->ImgWidth), mt_rand(0, $this->ImgHeight), $spot_color);
		}

		// 给图像画边框
		if ('' != $this->BorderColor)
		{
			imagerectangle($this->ResourceImage, 0, 0, $this->ImgWidth-1, $this->ImgHeight-1, $this->GetRGBColor($this->BorderColor));
		}

		return TRUE;
	}

	/**
	 * 取得颜色RGB值
	 *
	 * 取得颜色RGB值
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