<?php

namespace Screenpiece;

$include = realpath(__DIR__.'/../src');
set_include_path(get_include_path().PATH_SEPARATOR.$include);
spl_autoload_register(function($className) {
	$fileName = stream_resolve_include_path(
		strtr(ltrim($className, '\\'), '\\', '/').'.php'
	);
	
	if ($fileName) {
		require_once $fileName;
	}
});

$screenshot = GDImg::fromPath(__DIR__.'/data/google1.png');
$logo = GDImg::fromPath(__DIR__.'/data/googleLogo.png');
$start = microtime(true);
$pos = $screenshot->subImgPos($logo);
echo "time: " . (microtime(true) - $start) . "\n";
var_dump($pos);

$termsButton = GDImg::fromPath(__DIR__.'/data/googleTerms.png');
$start = microtime(true);
$pos = $screenshot->subImgPos($termsButton, null, true);
echo "time: " . (microtime(true) - $start) . "\n";
var_dump($pos);

$logo = new Piece(
	'Логотип Google',
	GDImg::fromPath(__DIR__.'/data/googleLogo.png'),
	Position::likeCss([
		'top' => 10,
		'left' => 10,
	])
);
$screenshot = GDImg::fromPath(__DIR__.'/data/google1.png');
$logoIsPresent = $logo->isPresented($screenshot);
var_dump($logoIsPresent);