<?php

namespace Kumatch\Path;

abstract class Platform
{

    abstract public function normalize($path);

    abstract public function join();

    abstract public function dirname($path);

    abstract public function basename($path, $ext = null);

    abstract public function extname($path);

    abstract protected function isAbsolute($path);
}