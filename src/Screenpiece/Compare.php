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
		$eq = true;
		list($img1Width, $img1Height) = $this->img1->size();
		list($img2Width, $img2Height) = $this->img2->size();

		$maxWidth = max($img1Width, $img2Width);
		$maxHeight = max($img1Height, $img2Height);

		$imgClass = get_class($this->img1);
		$diff = \call_user_func([$imgClass, 'createEmpty'], $maxWidth, $maxHeight);
		foreach ($diff->eachPixel() as $pixel) {
			if (
				($pixel['x'] < $img1Width && $pixel['x'] < $img2Width)
				&& ($pixel['y'] < $img1Height && $pixel['y'] < $img2Height)
			) {
				$p2 = $this->img2->getPixel($pixel['x'], $pixel['y']);
				if ($p2 >> 24 === 127 && $this->skipTransparent) {
					$diff->setPixel($pixel['x'], $pixel['y'], [0, 0, 0, 127]);
					continue;
				}
				$p1 = $this->img1->getPixel($pixel['x'], $pixel['y']);
				if ($p1 === $p2) {
					$diff->setPixel($pixel['x'], $pixel['y'], [0, 0, 0, 127]);
				} else {
					$eq = false;
					$diff->setPixel($pixel['x'], $pixel['y'], [255, 0, 0, 0]);
				}
			} else {
				$eq = false;
				$diff->setPixel($pixel['x'], $pixel['y'], [255, 0, 0, 0]);
			}
		}

		return [$eq, $diff];
	}

}
