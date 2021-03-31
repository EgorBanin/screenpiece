# Screenpiece

~~~php
$googleScreen = new Screen(
	GDImg::fromPath(__DIR__.'/tests/data/googleSample.png'),
	['Google logo' => new Piece([10, 10, 230, 100], [], 0)]
);
$screenshot = GDImg::fromPath(__DIR__.'/tests/data/googleScreenshot.png');
var_dump($googleScreen->equal($screenshot));
var_dump($googleScreen->piecePresent('Google logo', $screenshot));
~~~

~~~php
$screenshot = GDImg::fromPath(__DIR__.'/data/google1.png');
$logo = GDImg::fromPath(__DIR__.'/data/googleLogo.png');
$pos = Utils::search($screenshot, $logo)();
var_dump($pos);
~~~

example.php
~~~
docker-compose -f ./docker/docker-compose.yml run --rm php php app/example.php
~~~

тесты
~~~
docker-compose -f ./docker/docker-compose.yml run --rm php bash app/vendor/bin/phpunit -c app/tests/phpunit.xml app/tests
~~~