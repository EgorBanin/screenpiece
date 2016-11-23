# Screenpiece

~~~php
$el = new \Screenpiece\Element(
	'Логотип Goole',
	\Screenpiece\GDImg::fromPath(__DIR__.'/data/googleLogo.png'),
	\Screenpiece\Position::likeCss([
		'top' => 10,
		'left' => 10,
	])
);
$screenshot = \Screenpiece\GDImg::fromPath(__DIR__.'/data/google1.png');
$logoIsPresent = $el->isPresented($screenshot);
var_dump($logoIsPresent);
~~~