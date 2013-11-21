Path
===========

Utilities for file paths.

[![Build Status](https://travis-ci.org/kumatch/php-path.png?branch=master)](https://travis-ci.org/kumatch/php-path)


Install
-----

Add "kumatch/path" as a dependency in your project's composer.json file.


    {
      "require": {
        "kumatch/path": "*"
      }
    }

And install your dependencies.

    $ composer install


Methods
----

```php
<?php
use Kumatch\Path;
```


### Path::normalize($path)

Normalize a string path.

```php
Path.normalize("/foo//bar///baz/qux//../../quux");
// returns "/foo/bar/quux"

Path.normalize("foo/bar/../bar");
// returns "foo/bar"

Path.normalize("/foo/../../");
// returns "/"
```


### Path::join([$path1], [$path2], [...])

Join all arguments together and normalize path.

```php
Path.join("foo", "bar", "baz");
// returns "foo/bar/baz"

Path.join("/foo", "bar", "baz/qux", "quux");
// returns "/foo/bar/baz/qux/quux"

Path.join("/foo", "bar", "baz/qux", "../..");
// returns "/foo/bar"
```


### Path::dirname($path)

Return the directory name of a path. (same PHP `dirname($path)`.)

```php
Path.dirname("/foo/bar/baz");
// returns "foo/bar"

Path.dirname("foo/bar/baz/../qux");
// returns "foo/bar/baz/.."
```


### Path::basename($path, [$ext])

Return the last portion of a path. (same PHP `basename($path)`.)

```php
Path.basename("/path/to/foo.txt");
// returns "foo.txt"

Path.basename("/path/to/foo.txt", ".txt");
// returns "foo"

Path.basename("/path/to/foo.txt", "oo.txt");
// returns "f"

Path.basename("/path/to/foo.txt", "foo.txt");
// returns "foo.txt"
```


### Path::extname($path)

Return the extension of the path, from the last '.' to end of string.

```php
Path.extname("/path/to/foo.txt");
// returns ".txt"

Path.extname("foo.bar.jpeg");
// returns ".jpeg"

Path.extname("foo.");
// returns "."

Path.extname("foo");
// returns ""
```





License
--------

Licensed under the MIT License.

Copyright (c) 2013 Yosuke Kumakura

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
