<?php

class SearchTest extends \PHPUnit_Framework_TestCase {

	public function testCompare() {
		$screenshot = \Screenpiece\GDImg::fromPath(DATADIR.'/googleScreenshot.png');
		$logo = \Screenpiece\GDImg::fromPath(DATADIR.'/googleLogo.png');
		$search = Screenpiece\Utils::search($screenshot, $logo);
		$this->assertSame([[28, 50]], $search());

		$logo2 = \Screenpiece\GDImg::fromPath(DATADIR.'/googleLogo2.png');
		$search = Screenpiece\Utils::search($screenshot, $logo2);
		$this->assertSame([], $search());
	}

}
