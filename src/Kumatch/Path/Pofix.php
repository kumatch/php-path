<?php

namespace Kumatch\Path;

class Pofix extends Platform
{
    /**
     * @param $path
     * @return string
     */
    public function normalize($path)
    {
        $isAbsolute = $this->isAbsolute($path);
        $trailingSlash = substr($path, -1, 1) === '/';

        // Normalize the path
        $parts = array_values(array_filter(explode("/", $path), function($p) {
            return !!$p;
        }));

        $path = implode('/', $this->normalizeArray($parts, !$isAbsolute));

        if (!$path && !$isAbsolute) {
            $path = '.';
        }

        if ($path && $trailingSlash) {
            $path .= '/';
        }

        return ($isAbsolute ? '/' : '') . $path;
    }

    /**
     * @params $path1, $path2, ...
     * @return string
     * @throws \InvalidArgumentException
     */
    public function join()
    {
        $arguments = func_get_args();

        $paths = array_filter( $arguments, function ($v) {
            if (is_string($v) || is_numeric($v) || is_float($v)) {
                return true;
            } else {
                throw new \InvalidArgumentException('arguments must be strings');
            }
        });

        return $this->normalize(implode('/', $paths));
    }

    /**
     * @param string $path
     * @return string
     * @see dirname()
     */
    public function dirname($path)
    {
        return dirname($path);
    }

    /**
     * @param string $path
     * @param string|null $ext
     * @return string
     */
    public function basename($path, $ext = null)
    {
        return basename($path, $ext);
    }

    /**
     * @param string $path
     * @return string
     */
    public function extname($path)
    {
        $basename = basename($path);

        if (preg_match('/^[\.]{1,2}$/', $basename)) {
            return "";
        }

        if (preg_match('/[\.]+$/', $basename)) {
            return ".";
        }

        $extname = pathinfo($basename, PATHINFO_EXTENSION);

        return $extname ? sprintf('.%s', $extname) : "";
    }


    /**
     * @param $path
     * @return bool
     */
    protected function isAbsolute($path)
    {
        return (substr($path, 0, 1) === '/');
    }

    protected function normalizeArray($parts, $allowAboveRoot)
    {
        $partsLength = count($parts);
        $up = 0;

        for ($i = $partsLength - 1; $i >= 0; --$i) {
            $last = $parts[$i];

            if ($last === '.') {
                array_splice($parts, $i, 1);
            } else if ($last === '..') {
                array_splice($parts, $i, 1);
                ++$up;
            } else if ($up) {
                array_splice($parts, $i, 1);
                --$up;
            }
        }

        // if the path is allowed to go above the root, restore leading ..s
        if ($allowAboveRoot) {
            for (; $up--; $up) {
                array_unshift($parts, '..');
            }
        }

        return $parts;
    }
}