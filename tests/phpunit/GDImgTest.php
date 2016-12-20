<?php

class GDImgTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider provideSubImgPos
	 */
	public function testSubImgPos($img, $subimg, $expectedPos) {
		$screenshot = \Screenpiece\GDImg::fromPath($img);
		$logo = \Screenpiece\GDImg::fromPath($subimg);
		$pos = $screenshot->subImgPos($logo);
		$this->assertSame($expectedPos, $pos);
	}

	public function provideSubImgPos() {
		return [
			[
				DATADIR.'/google1.png',
				DATADIR.'/googleLogo.png',
				[[10, 10]],
			],
			[
				DATADIR.'/googleLogo.png',
				DATADIR.'/googleLogo.png',
				[[0, 0]],
			],
		];
	}

	public function testSubImgPosReverce() {
		$screenshot = \Screenpiece\GDImg::fromPath(DATADIR.'/google1.png');
		$terms = \Screenpiece\GDImg::fromPath(DATADIR.'/googleTerms.png');

		$start = microtime(true);
		$pos1 = $screenshot->subImgPos($terms, 0);
		$time1 = (microtime(true) - $start);

		$this->assertCount(1, $pos1, 'Ожидаем единственное совпадение');

		$start = microtime(true);
		$pos2 = $screenshot->subImgPos($terms, 1, null, true);
		$time2 = (microtime(true) - $start);

		$this->assertEquals($pos1, $pos2, 'Ожидаем, что найденые позиции совпадают');
		$this->assertLessThan($time1, $time2, 'Поиск до первого вхождения снизу вверх быстрее');
	}

	public function testSubImgPosAll() {
		$screenshot = \Screenpiece\GDImg::fromPath(DATADIR.'/google1.png');
		$logo = \Screenpiece\GDImg::fromPath(DATADIR.'/o.png');
		$pos = $screenshot->subImgPos($logo, 0, [0, 2700, INF, INF]);
		$expectedCount = 9;
		$this->assertCount($expectedCount, $pos, "Ожидаем $expectedCount вхождений");
	}

}