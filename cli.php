<?php

$include = realpath(__DIR__.'/src');
set_include_path(get_include_path().PATH_SEPARATOR.$include);
spl_autoload_register(function($className) {
	$fileName = stream_resolve_include_path(
		strtr(ltrim($className, '\\'), '\\', '/').'.php'
	);
	
	if ($fileName) {
		require_once $fileName;
	}
});

$piece = isset($argv[1])? $argv[1] : null;
$screen = isset($argv[2])? $argv[2] : null;

$screenImg = \Screenpiece\GDImg::fromPath($screen);
$pieceImg = \Screenpiece\GDImg::fromPath($piece);

$diff = $screenImg
	->diff($pieceImg)();
//	->setLimit(1)
//	->setSkipTransparent(true)();

$f = tempnam('/tmp', 'diff.');
file_put_contents($f, (string) $diff);
echo $f, "\n";