<?php declare(strict_types=1);

namespace SecretServer\Services;

/**
 * Provides a utility for loading configuration files.
 *
 * The `Config` class provides a static `get()` method that can be used to load
 * configuration files from the `config` directory. If the requested file does
 * not exist or is not readable, a default value will be returned.
 * 
 * @author Farsang Balázs <farsang.balazs617@gmail.com>
 */
class Config
{
    /**
     * The path to the configuration directory.
     */
    const CONFIG_PATH = ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

    /**
     * Loads a configuration file from the `config` directory and returns its contents.
     *
     * If the requested configuration file does not exist or is not readable, the
     * provided default value will be returned instead.
     *
     * @param string $fileName The name of the configuration file to load (without the `.php` extension).
     * @param mixed $default The default value to return if the configuration file cannot be loaded.
     * 
     * @return mixed The contents of the configuration file, or the provided default value.
     */
    public static function get(string $fileName, mixed $default = null): mixed
    {
        $filePath = self::CONFIG_PATH . $fileName . '.php';

        if (!file_exists($filePath) || !is_readable($filePath)) {
            return $default;
        }

        $config = include $filePath;

        if (!is_array($config)) {
            return $default;
        }

        return $config;
    }
}
