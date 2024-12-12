<?php declare(strict_types=1);

/**
 * @author Farsang Balázs <farsang.balazs617@gmail.com>
 */

define('ROOT', dirname(__DIR__));

define('VENDOR', ROOT . DIRECTORY_SEPARATOR . 'vendor');

require VENDOR . DIRECTORY_SEPARATOR . 'autoload.php';

$App = \SecretServer\Application::getInstance();

$App->run();
