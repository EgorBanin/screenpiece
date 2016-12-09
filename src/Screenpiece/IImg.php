<?php

namespace Screenpiece;

interface IImg {

	public function size();

	public function subImgPos(IImg $subimg, $limit = 1, $area = null, $reverse = false);

	public function getPixel($x, $y);

}