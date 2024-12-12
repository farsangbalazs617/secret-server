<?php declare(strict_types=1);

/**
 * @author Farsang Balázs <farsang.balazs617@gmail.com>
 */

define('ROOT', __DIR__);

define('VENDOR', ROOT . DIRECTORY_SEPARATOR . 'vendor');

define('SRC', ROOT . DIRECTORY_SEPARATOR . 'src');

define('STORAGE_DIR', SRC . DIRECTORY_SEPARATOR . 'Storage');

require VENDOR . DIRECTORY_SEPARATOR . 'autoload.php';

$App = \SecretServer\Application::getInstance();

$App->run();
