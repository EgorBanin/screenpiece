<?php

class PieceTest extends \PHPUnit_Framework_TestCase {

	public function testGetBounds() {
		$screenshot = \Screenpiece\GDImg::fromPath(DATADIR.'/google1.png');
		$logo = new \Screenpiece\Piece(
			'Логотип Google',
			\Screenpiece\GDImg::fromPath(DATADIR.'/googleLogo.png'),
			\Screenpiece\Position::initByCorners([
				'top' => 10,
				'left' => 10,
			]),
			0
		);
		$bounds = $logo->getBounds($screenshot);
		$this->assertSame([
			'x' => 10,
			'y' => 10,
			'width' => 230,
			'height' => 100,
		], $bounds, 'Ожидаем, что получим границы лого на скриншоте');

		$logo = new \Screenpiece\Piece(
			'Логотип Google',
			\Screenpiece\GDImg::fromPath(DATADIR.'/googleLogo.png'),
			\Screenpiece\Position::initByCorners([
				'top' => 11,
				'left' => 11,
			]),
			0
		);
		$bounds = $logo->getBounds($screenshot);
		$this->assertSame(false, $bounds, 'Ожидаем, что лого не найден в неверной позиции');
	}

	public function testIsPresent() {
		$screenshot = \Screenpiece\GDImg::fromPath(DATADIR.'/google1.png');
		$logo = new \Screenpiece\Piece(
			'Логотип Google',
			\Screenpiece\GDImg::fromPath(DATADIR.'/googleLogo.png'),
			\Screenpiece\Position::initByCorners([
				'top' => 10,
				'left' => 10,
			]),
			0
		);
		$isPresent = $logo->isPresent($screenshot);
		$this->assertSame(true, $isPresent, 'Ожидаем, что лого присутствует на экране в указаной позиции');
	}

}