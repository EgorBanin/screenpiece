<?php

namespace Screenpiece;

class Screen {

	private $img;

	private $pieces = [];

	public function __construct(IImg $img, $pieces) {
		$this->img = $img;
		$this->pieces = $pieces;
	}

	public function equal(IImg $img) {
		$compare = Utils::compare($img, $this->img)
			->setSkipTransparent(true);

		return $compare();
	}

	public function piecePresent($pieceName, IImg $img) {
		$piece = isset($this->pieces[$pieceName])? $this->pieces[$pieceName] : null;
		if ( ! $piece) {
			throw new \Exception('Не найден фрагмент '.$pieceName);
		}

		list($x, $y, $width, $heigth) = $piece->getBounds();
		$subImg = $this->img->copy($x, $y, $width, $heigth);
		$search = Utils::search($img, $subImg)
			->setSkipTransparent(true);
		$pos = $search();

		if ($pos) {
			// todo проверить, что позиция в ожидаемом диапазоне
			$isPresent = true;
		} else {
			$isPresent = false;
		}

		return $isPresent;
	}

	public function toArray() {
		return [
			'src' => (string) $this->img,
			'pieces' => array_map($this->pieces, function($piece) {
				return $piece->toArray();
			}),
		];
	}

}
