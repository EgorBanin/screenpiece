<?php

namespace Screenpiece;

interface IImg {

	public function size();

	/**
	 * Поиск позиции изображения в другом изображении
	 * @param IImg $subimg искомое изображение
	 * @param int $limit лимит количества вхождений, 0 -- все вхождения
	 * @param array $area [x, y, width, height]
	 * @param bool $reverse искать с конца (снизу вверх)
	 * @return array массив позиций (координат левого верхнего угла) [[x, y], ...]
	 */
	public function subImgPos(IImg $subimg, $limit = 1, $area = null, $reverse = false);

	public function getPixel($x, $y);

}