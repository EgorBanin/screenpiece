<?php

namespace Screenpiece;

class Piece {

	private $name;

	private $img;

	private $position;

	public function __construct($name, IImg $img, $position) {
		$this->name = $name;
		$this->img = $img;
		$this->position = $position;
	}

	public function getName() {
		return $this->name;
	}

	public function isPresent(IImg $screenshot) {
		$bounds = $this->getBounds($screenshot);

		return $bounds? true : false;
	}

	public function getBounds(IImg $screenshot) {
		$positions = $screenshot->subImgPos(
			$this->img,
			1,
			$this->position->getRect(),
			! $this->position->onTop()
		);
		$pos = reset($positions);

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