<?php

namespace Screenpiece;

class Position {

	private $x1;

	private $y1;

	private $x2;

	private $y2;

	private $onTop;

	public function __construct(array $x1, array $y1, array $x2, array $y2, $onTop) {
		$this->x1 = $x1;
		$this->y1 = $y1;
		$this->x2 = $x2;
		$this->y2 = $y2;
		$this->onTop = $onTop;
	}

	public static function likeCss($position) {
		$top = isset($position['top'])? $position['top'] : null;
		$left = isset($position['left'])? $position['left'] : null;
		$bottom = isset($position['bottom'])? $position['bottom'] : null;
		$right = isset($position['right'])? $position['right'] : null;

		if (isset($top) && isset($bottom)) {
			$x1 = self::normalizeCoord($top);
			$x2 = self::normalizeCoord($bottom);
		} elseif (isset($top) && ! isset($bottom)) {
			$x1 = self::normalizeCoord($top);
			$x2 = $x1;
		} elseif ( ! isset($top) && isset($bottom)) {
			$x2 = self::normalizeCoord($bottom);
			$x1 = $x2;
		} else {
			$x1 = [0, INF];
			$x2 = [0, INF];
		}

		if (isset($left) && isset($right)) {
			$y1 = self::normalizeCoord($left);
			$y2 = self::normalizeCoord($right);
		} elseif (isset($left) && ! isset($right)) {
			$y1 = self::normalizeCoord($left);
			$y2 = $y1;
		} elseif ( ! isset($left) && isset($right)) {
			$y2 = self::normalizeCoord($right);
			$y1 = $y2;
		} else {
			$y1 = [0, INF];
			$y2 = [0, INF];
		}

		$onTop = isset($top);

		return new self($x1, $y1, $x2, $y2, $onTop);
	}

	public static function normalizeCoord($val) {
		$val = (array) $val;
		if (count($val) === 1) {
			$val[] = $val[0];
		}

		return $val;
	}

	public function getRect() {
		$x = min($this->x1);
		$y = min($this->y1);
		$width = max($this->x2) - $x + 1;
		$height = max($this->y2) - $y + 1;

		return [$x, $y, $width, $height];
	}

	public function onTop() {
		return $this->onTop;
	}

}