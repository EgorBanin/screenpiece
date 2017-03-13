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

	// @todo: перенести
	public function subImgPos(IImg $subimg, $limit = 1, $area = null, $reverse = false, $skipTransparent = false) {
		list($imgWidth, $imgHeight) = $this->size();
		list($subimgWidth, $subimgHeight) = $subimg->size();

		$x = 0;
		$y = 0;
		$width = $imgWidth - $subimgWidth + 1;
		$height = $imgHeight - $subimgHeight + 1;

		if ($area) {
			list($areaX, $areaY, $areaWidth, $areaHeight) = $area;
			$x = max($x, $areaX);
			$y = max($y, $areaY);
			$width = min($width - $x, $areaWidth);
			$height = min($height - $y, $areaHeight);
		}

		$results = [];
		$keyPoint = null;
		foreach ($this->eachPixel([$x, $y, $width, $height], $reverse) as $imgPixel) {
			// первым делом проверяем ключевую точку
			if ($keyPoint) {
				$imgColor = $this->getPixel($imgPixel['x'] + $keyPoint[0], $imgPixel['y'] + $keyPoint[1]);
				$subimgColor = $subimg->getPixel($keyPoint[0], $keyPoint[1]);

				if ($imgColor !== $subimgColor) {
					continue;
				}
			}

			// проверям все точки
			$eq = true;
			foreach ($subimg->eachPixel() as $subimgPixel) {
				if ($subimgPixel['color'] >> 24 === 127 && $skipTransparent) {
					continue;
				}
				$imgColor = $this->getPixel($imgPixel['x'] + $subimgPixel['x'], $imgPixel['y'] + $subimgPixel['y']);
				if ($imgColor !== $subimgPixel['color']) {
					$eq = false;
					$keyPoint = [$subimgPixel['x'], $subimgPixel['y']];
					break;
				}
			}

			if ($eq) {
				// todo не искать на найденом
				$results[] = [$imgPixel['x'], $imgPixel['y']];
				if ($limit > 0 && count($results) >= $limit) {
					break;
				}
			}
		}

		return $results;
	}
	
}