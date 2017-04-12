<?php

require __DIR__.'/vendor/autoload.php';

$googleScreen = new \Screenpiece\Screen(
	\Screenpiece\GDImg::fromPath(__DIR__.'/tests/data/googleSample.png'),
	['Google logo' => new \Screenpiece\Piece([10, 10, 230, 100], [], 0)]
);
$screenshot = \Screenpiece\GDImg::fromPath(__DIR__.'/tests/data/googleScreenshot.png');


$start = microtime(true);
var_dump($googleScreen->equal($screenshot));
echo 'time: ', microtime(true) - $start, "\n";

$start = microtime(true);
var_dump($googleScreen->piecePresent('Google logo', $screenshot));
echo 'time: ', microtime(true) - $start, "\n";