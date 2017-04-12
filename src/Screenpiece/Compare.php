<?php

namespace Screenpiece;

class Compare {

	private $img1;

	private $img2;

	private $skipTransparent = false;

	public function __construct(IImg $img1, IImg $img2) {
		$this->img1 = $img1;
		$this->img2 = $img2;
	}

	public function setSkipTransparent($skipTransparent) {
		$this->skipTransparent = $skipTransparent;

		return $this;
	}

	public function __invoke() {
		if ($this->img1->size() !== $this->img2->size()) {
			return false;
		}

		$eq = true;
		foreach ($this->img2->eachPixel() as $pixel) {
			if ($pixel['color'] >> 24 === 127 && $this->skipTransparent) {
				continue;
			}
			$srcColor = $this->img1->getPixel($pixel['x'], $pixel['y']);
			if ($srcColor !== $pixel['color']) {
				$eq = false;
				break;
			}
		}

		return $eq;
	}

}
