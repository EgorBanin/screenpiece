<?php

namespace Screenpiece;

class Search {

	private $img;

	private $subImg;

	private $area = null;

	private $limit = 0;

	private $reverse = false;

	private $skipTransparent = false;

	public function __construct(IImg $img, IImg $subImg) {
		$this->img = $img;
		$this->subImg = $subImg;
	}

	public function setArea($area) {
		$this->area = $area;

		return $this;
	}

	public function setLimit($limit) {
		$this->limit = $limit;

		return $this;
	}

	public function setReverse($reverse) {
		$this->reverse = $reverse;

		return $this;
	}

	public function setSkipTransparent($skipTransparent) {
		$this->skipTransparent = $skipTransparent;

		return $this;
	}

	/**
	 * Найти позиции вхождения
	 * @return array
	 */
	public function __invoke() {
		list($imgWidth, $imgHeight) = $this->img->size();
		list($subImgWidth, $subImgHeight) = $this->subImg->size();

		$x = 0;
		$y = 0;
		$width = $imgWidth - $subImgWidth + 1;
		$height = $imgHeight - $subImgHeight + 1;

		if ($this->area) {
			list($areaX, $areaY, $areaWidth, $areaHeight) = $this->area;
			$x = max($x, $areaX);
			$y = max($y, $areaY);
			$width = min($width - $x, $areaWidth);
			$height = min($height - $y, $areaHeight);
		}

		$results = [];
		$keyPoint = null;
		foreach ($this->img->eachPixel([$x, $y, $width, $height], $this->reverse) as $imgPixel) {
			// первым делом проверяем ключевую точку
			if ($keyPoint) {
				$imgColor = $this->img->getPixel($imgPixel['x'] + $keyPoint[0], $imgPixel['y'] + $keyPoint[1]);
				$subImgColor = $this->subImg->getPixel($keyPoint[0], $keyPoint[1]);

				if ($imgColor !== $subImgColor) {
					continue;
				}
			}

			// проверям все точки
			$eq = true;
			foreach ($this->subImg->eachPixel() as $subImgPixel) {
				if ($subImgPixel['color'] >> 24 === 127 && $this->skipTransparent) {
					continue;
				}
				$imgColor = $this->img->getPixel($imgPixel['x'] + $subImgPixel['x'], $imgPixel['y'] + $subImgPixel['y']);
				if ($imgColor !== $subImgPixel['color']) {
					$eq = false;
					$keyPoint = [$subImgPixel['x'], $subImgPixel['y']];
					break;
				}
			}

			if ($eq) {
				// todo не искать на найденом
				$results[] = [$imgPixel['x'], $imgPixel['y']];
				if ($this->limit > 0 && \count($results) >= $this->limit) {
					break;
				}
			}
		}

		return $results;
	}

}

