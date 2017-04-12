<?php

namespace Screenpiece;

class Piece {

	private $bounds;

	private $position;

	private $index;

	public function __construct($bounds, $position, $index) {
		$this->bounds = $bounds;
		$this->position = $position;
		$this->index = $index;
	}

	public function getBounds() {
		return $this->bounds;
	}
	
	public function getPosition() {
		return $this->position;
	}

	public function getIndex() {
		return $this->index;
	}

}