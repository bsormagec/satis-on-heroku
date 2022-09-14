#!/usr/bin/env php
<?php

/**
 * Renders a Twig template and outputs the results.
 *
 * Example:
 *
 *     php bin/render-template.php views/satis.json.twig > satis.json
 */

namespace Matthimatiker\SatisOnHeroku;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once(__DIR__ . '/../vendor/autoload.php');

if (!isset($_SERVER['argv'][1])) {
    echo 'Usage: php ' . __FILE__ . ' <path-to-template>' . PHP_EOL;
    exit(1);
}
$template = $_SERVER['argv'][1];
if (!is_file($template)) {
    echo 'Template file "' . $template . '" does not exist.' . PHP_EOL;
    exit(1);
}

$repositories = array_filter($_SERVER, function ($key) {
    return strpos($key, 'SATIS_REPOSITORY_') === 0;
}, ARRAY_FILTER_USE_KEY);

$loader = new FilesystemLoader(dirname($template));
$twig = new Environment($loader);

echo $twig->render(basename($template), array(
    'env' => $_SERVER,
    'repositories' => $repositories
));
