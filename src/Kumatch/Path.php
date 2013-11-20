<?php

namespace Kumatch;

use Kumatch\Path\Pofix;

class Path
{
    protected static $platform;

    /**
     * @param string $path
     * @return string mixed
     */
    public static function normalize($path)
    {
        return static::createPlatform()->normalize($path);
    }

    /**
     * @params $path1, $path2, ...
     * @throws \InvalidArgumentException
     */
    public static function join()
    {
        return call_user_func_array( array(static::createPlatform(), "join"), func_get_args() );
    }

    /**
     * @param string $path
     * @return string
     * @see dirname()
     */
    public static function dirname($path)
    {
        return static::createPlatform()->dirname($path);
    }

    /**
     * @param string $path
     * @param string|null $ext
     * @return mixed
     */
    public static function basename($path, $ext = null)
    {
        return static::createPlatform()->basename($path, $ext);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function extname($path)
    {
        return static::createPlatform()->extname($path);
    }

    /**
     * @throws \Exception
     * @return Path\Platform
     */
    public static function createPlatform()
    {
        if (!static::$platform) {
            if (static::isWindowsPlatform()) {
                throw new \Exception('Not supported in Windows platform :(');
            }

            static::$platform = new Pofix();
        }

        return static::$platform;
    }

    /**
     * @return bool
     */
    protected static function isWindowsPlatform()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}