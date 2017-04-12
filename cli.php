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

$method = isset($argv[1])? $argv[1] : null;
$filename1 = isset($argv[2])? $argv[2] : null;
$filename2 = isset($argv[3])? $argv[3] : null;

$opts = [];
foreach ($argv as $part) {
	if (strpos($part, '-') === 0) {
		list($name, $val) = explode('=', ltrim($part, '-'), 2);
		$opts[$name] = trim($val, '"\'');
	}
}

$availableMethods = [
	'help',
	'search',
	'compare',
];

$errCode = 0;

if ( ! in_array($method, $availableMethods)) {
	$method = 'help';
	$errCode = 1;
}

if ($filename1 && $filename2) {
	$img1 = \Screenpiece\GDImg::fromPath($filename1);
	$img2 = \Screenpiece\GDImg::fromPath($filename2);
}

switch ($method) {
	case 'help':
	default:
		echo "Usage:\n";
		echo "php cli.php search haystackImage needleImage\n";
		echo "php cli.php compare imageA imageB --diff=file_for_save_diff_image\n";
		echo "php cli.php help\n";
		break;

	case 'search':
		$pos = \Screenpiece\Utils::search($img1, $img2)();
		if (empty($pos)) {
			echo "not found\n";
		}

		foreach ($pos as $i => $position) {
			echo "$i: ".implode(', ', $position)."\n";
		}
		break;

	case 'compare':
		$compare = \Screenpiece\Utils::compare($img1, $img2);
		$isEquals = $compare();

		if ( ! empty($opts['diff'])) {
			$diffFile = realpath($opts['diff']);
			$diff = \Screenpiece\Utils::diff($img1, $img2);
			file_put_contents($diffFile, (string) $diff());
		}

		echo $isEquals? "same\n" : "different\n";
		break;

}

exit($errCode);