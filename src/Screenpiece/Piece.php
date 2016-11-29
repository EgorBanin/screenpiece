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

	public function isPresented(IImg $screenshot) {
		$bounds = $this->getBounds($screenshot);

		return $bounds? true : false;
	}

	public function getBounds(IImg $screenshot) {
		$pos = $screenshot->subImgPos(
			$this->img,
			$this->position->getRect(),
			! $this->position->onTop()
		);

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