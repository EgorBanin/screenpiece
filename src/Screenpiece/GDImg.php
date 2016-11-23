<?php

namespace Screenpiece;

class GDImg implements IImg {

	private $img;

	public function __construct($img) {
		$this->img = $img;
	}

	public static function fromPath($path) {
		$img = \imagecreatefrompng($path);
		\imagepalettetotruecolor($img);

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

	public function subImgPos(IImg $subimg, $area = null, $reverse = false) {
		list($imgWidth, $imgHeight) = $this->size();
		list($subimgWidth, $subimgHeight) = $subimg->size();

		$x = 0;
		$y = 0;
		$width = $imgWidth - $subimgWidth;
		$height = $imgHeight - $subimgHeight;

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

		$result = false;
		$keyPoint = null;
		for ($i = 0; $i < $height; ++$i) {
			$imgX = $x;
			for ($j = 0; $j < $width; ++$j) {
				// первым делом проверяем ключевую точку
				if ($keyPoint) {
					$imgColor = $this->getPixel($imgX + $keyPoint[0], $imgY + $keyPoint[1]);
					$subimgColor = $subimg->getPixel($keyPoint[0], $keyPoint[1]);

					if ($imgColor !== $subimgColor) {
						++$imgX;
						continue;
					}
				}

				// проверям все точки
				$eq = true;
				$subimgY = 0;
				while ($subimgY < $subimgHeight) {
					$subimgX = 0;
					while ($subimgX < $subimgWidth) {
						$imgColor = $this->getPixel($imgX + $subimgX, $imgY + $subimgY);
						$subimgColor = $subimg->getPixel($subimgX, $subimgY);

						if ($imgColor !== $subimgColor) {
							$eq = false;
							$keyPoint = [$subimgX, $subimgY];
							break 2;
						}

						++$subimgX;
					}

					++$subimgY;
				}

				if ($eq) {
					$result = [$imgX, $imgY];
					break 2;
				}

				++$imgX;
			}

			$imgY += $step;
		}

		return $result;
	}
	
}