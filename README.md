# Screenpiece

~~~php
$screenshot = GDImg::fromPath(__DIR__.'/data/google1.png');
$logo = GDImg::fromPath(__DIR__.'/data/googleLogo.png');
$pos = Utils::search($screenshot, $logo)();
var_dump($pos);
~~~

~~~php
$googleScreen = new Screen(
	GDImg::fromPath(__DIR__.'/data/google1.png'),
	['Google logo' => new Piece([10, 10, 230, 100], [], 0)]
);
$screenshot = GDImg::fromPath(__DIR__.'/data/google2.png');
var_dump($googleScreen->equal($screenshot));
var_dump();
~~~