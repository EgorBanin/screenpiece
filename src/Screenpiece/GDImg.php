<?php

namespace Screenpiece;

class GDImg implements IImg {

	private $img;

	public function __construct($img) {
		\imagepalettetotruecolor($img);
		\imagealphablending($img, false);
		\imagesavealpha($img, true);
		\imagecolorallocatealpha($img, 0, 0, 0, 127);
		$this->img = $img;
	}

	public static function createEmpty($w, $h) {
		$img = \imagecreatetruecolor($w, $h);

		return new self($img);
	}

	public static function fromPath($path) {
		$img = \imagecreatefrompng($path);

		return new self($img);
	}

	public static function fromString($str) {
		$img = \imagecreatefromstring($str);

		return new self($img);
	}

	public function __destruct() {
		\imagedestroy($this->img);
	}

	public function size() {
		$size = [
			\imagesx($this->img),
			\imagesy($this->img),
		];

		return $size;
	}

	public function getPixel($x, $y) {
		$colorId = \imagecolorat($this->img, $x, $y);

		return $colorId;
	}

	public function setPixel($x, $y, $color) {
		list($r, $g, $b, $a) = $color;
		$c = \imagecolorallocatealpha($this->img, $r, $g, $b, $a);
		\imagesetpixel($this->img, $x, $y, $c);
	}

	public function eachPixel($area = null, $reverse = false) {
		list($width, $height) = $this->size();
		$x = 0;
		$y = 0;

		if ($area) {
			list($areaX, $areaY, $areaWidth, $areaHeight) = $area;
			$x = max($x, $areaX);
			$y = max($y, $areaY);
			$width = min($width - $x, $areaWidth);
			$height = min($height - $y, $areaHeight);
		}

		// определяем направление обхода
		if ($reverse) {
			$step = -1;
			$imgY = $height;
		} else {
			$step = 1;
			$imgY = $y;
		}

		for ($i = 0; $i < $height; ++$i) {
			$imgX = $x;
			for ($j = 0; $j < $width; ++$j) {
				$imgColor = $this->getPixel($imgX, $imgY);
				yield [
					'x' => $imgX,
					'y' => $imgY,
					'color' => $imgColor,
				];
				++$imgX;
			}

			$imgY += $step;
		}
	}

	public function subImgPos(IImg $subimg, $limit = 1, $area = null, $reverse = false, $skipTransparent = false) {
		$search = Utils::search($this, $subimg)
			->setLimit($limit)
			->setArea($area)
			->setReverse($reverse)
			->setSkipTransparent($skipTransparent);

		return $search();
	}

	public function __toString() {
		\ob_start();
		\imagepng($this->img);
		$data = \ob_get_clean();

		return $data;
	}
	
}