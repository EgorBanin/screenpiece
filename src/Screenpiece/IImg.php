<?php

namespace Screenpiece;

interface IImg {

	public function size();

	public function subImgPos(IImg $subimg, $area = null, $reverse = false);

	public function getPixel($x, $y);

}