<?php

class CompareTest extends \PHPUnit_Framework_TestCase {

	public function testCompare() {
		$logo = \Screenpiece\GDImg::fromPath(DATADIR.'/googleLogo.png');
		$compare = Screenpiece\Utils::compare($logo, $logo);
		$this->assertSame(true, $compare());
		$logo2 = \Screenpiece\GDImg::fromPath(DATADIR.'/googleLogo2.png');
		$compare = Screenpiece\Utils::compare($logo, $logo2);
		$this->assertSame(false, $compare());
	}

}
