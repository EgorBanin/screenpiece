<?php

namespace Screenpiece;

class Piece {

	private $name;

	private $img;

	private $position;

	private $index;

	public function __construct($name, IImg $img, $position, $index) {
		$this->name = $name;
		$this->img = $img;
		$this->position = $position;
		$this->index = $index;
	}

	public function getName() {
		return $this->name;
	}

	public function isPresent(IImg $screenshot) {
		$bounds = $this->getBounds($screenshot);

		return $bounds? true : false;
	}

	/**
	 * Получить границы фрагмента, если он найден на скриншоте
	 * @param IImg $screenshot
	 * @return array|false {x: int, y: int, width: int, height: int}
	 */
	public function getBounds(IImg $screenshot) {
		$limit = $this->index + 1;
		$positions = $screenshot->subImgPos(
			$this->img,
			$limit,
			$this->position->getRect(),
			! $this->position->onTop()
		);
		$pos = isset($positions[$this->index])? $positions[$this->index] : false;

		if ($pos) {
			list($width, $height) = $this->img->size();
			$bounds = [
				'x' => $pos[0],
				'y' => $pos[1],
				'width' => $width,
				'height' => $height,
			];
		} else {
			$bounds = false;
		}

		return $bounds;
	}

}