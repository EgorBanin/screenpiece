# Screenpiece

~~~php
$screenshot = GDImg::fromPath(__DIR__.'/data/google1.png');
$logo = GDImg::fromPath(__DIR__.'/data/googleLogo.png');
$pos = $screenshot->search($logo)();
var_dump($pos);
~~~

~~~php
$logo = new Piece(
	'Логотип Google',
	GDImg::fromPath(__DIR__.'/data/googleLogo.png'),
	Position::initByCorners([
		'top' => 10,
		'left' => 10,
	]),
	0
);
$screenshot = GDImg::fromPath(__DIR__.'/data/google1.png');
$logoIsPresent = $logo->isPresent($screenshot);
var_dump($logoIsPresent);
~~~