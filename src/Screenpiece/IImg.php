<?php

namespace Screenpiece;

interface IImg {

	public static function createEmpty($w, $h);

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

	public function setPixel($x, $y, $color);

	/**
	 * Генератор для обхода пикселей
	 * @param array $area [x, y, width, height]
	 * @param bool $reverse с конца (снизу вверх)
	 * @return \Generator
	 */
	public function eachPixel($area = null, $reverse = false);

	/**
	 * Объект поиска позиции изображения в текущем
	 * @param IImg $subImg
	 * @return Search
	 */
	public function search(IImg $subImg);

	public function __toString();

}