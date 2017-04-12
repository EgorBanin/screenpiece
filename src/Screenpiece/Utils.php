<?php

namespace Screenpiece;

class Utils {

	public static function search(IImg $img, IImg $subImg) {
		$search = new Search($img, $subImg);

		return $search;
	}

	public static function compare(IImg $img1, IImg $img2) {
		$compare = new Compare($img1, $img2);

		return $compare;
	}

	public static function diff(IImg $img1, IImg $img2) {
		$diff = new Diff($img1, $img2);

		return $diff;
	}

}