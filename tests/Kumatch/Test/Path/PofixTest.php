<?php

namespace Kumatch\Test\Path;

use Kumatch\Path\Pofix;

class PathTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }


    public function provideNormalize()
    {
        return array(
            array('/foo/bar//baz', '/foo/bar/baz'),
            array('/foo//bar///baz/qux//../../quux', '/foo/bar/quux'),

            array('foo/bar/../bar', 'foo/bar'),

            array('/foo/..',    '/'),
            array('/foo/../..', '/'),
            array('/foo/../../', '/'),

            array('foo/.',    'foo'),
            array('foo/..',   '.'),
            array('foo/../',  './'),
            array('foo/../.',  '.'),
            array('foo/../..', '..'),

            array('..',  '..'),
            array('../', '../'),
            array('../.', '..'),
            array('../../', '../../'),
            array('../../../../', '../../../../'),

            array('/', '/'),
            array('/.', '/'),
            array('/..', '/'),
            array('/../', '/'),
            array('/../../../../../foo/bar/../../../../baz/qux', '/baz/qux'),
        );
    }

    /**
     * @test
     * @dataProvider provideNormalize
     */
    public function normalize($input, $output)
    {
        $pofix = new Pofix();

        $this->assertEquals($output, $pofix->normalize($input));
    }



    public function provideJoin()
    {
        return array(
            array( array('foo', 'bar'), 'foo/bar' ),
            array( array(), '.' ),

            array( array('/foo', 'bar', 'baz/qux', 'quux'), '/foo/bar/baz/qux/quux' ),
            array( array('/foo', 'bar', 'baz/qux', '../..'), '/foo/bar' ),
            array( array('foo', 'bar', 'baz//..//baz'), 'foo/bar/baz'),
        );
    }

    /**
     * @test
     * @dataProvider provideJoin
     */
    public function join($input, $output)
    {
        $pofix = new Pofix();

        $this->assertEquals($output, call_user_func_array( array($pofix, 'join'), $input));
    }

    public function provideDirname()
    {
        return array(
            array("/foo/bar/baz/qux", "/foo/bar/baz"),
            array("foo/bar/baz/", "foo/bar"),
            array("foo/bar/baz/../qux", "foo/bar/baz/..")
        );
    }

    /**
     * @test
     * @dataProvider provideDirname
     */
    public function dirname($input, $output)
    {
        $pofix = new Pofix();

        $this->assertEquals($output, $pofix->dirname($input));
    }



    public function provideBasename()
    {
        return array(
            array('/path/to/foo.txt', null, 'foo.txt'),
            array('/path/to/foo.txt', '.txt', 'foo'),
            array('/path/to/foo.txt', '.html', 'foo.txt'),
            array('/path/to/foo.txt', 'oo.txt', 'f'),
            array('/path/to/foo.txt', 'foo.txt', 'foo.txt'),

            array('/マルチ/バイト/ファイルand名123.html', null, 'ファイルand名123.html'),
            array('/マルチ/バイト/ファイルand名123.html', '.html', 'ファイルand名123'),
            array('/マルチ/バイト/ファイルand名123.html', '.txt', 'ファイルand名123.html'),
            array('/マルチ/バイト/ファイルand名123.html', '123.html', 'ファイルand名'),
            array('/マルチ/バイト/ファイルand名123.html', '名123.html', 'ファイルand'),
            array('/マルチ/バイト/ファイルand名123.html', 'and名123.html', 'ファイル'),
            array('/マルチ/バイト/ファイルand名123.html', 'ァイルand名123.html', 'フ'),
            array('/マルチ/バイト/ファイルand名123.html', 'ファイルand名123.html', 'ファイルand名123.html'),
        );
    }

    /**
     * @test
     * @dataProvider provideBasename
     */
    public function basename($input, $ext, $output)
    {
        $pofix = new Pofix();

        if (is_null($ext)) {
            $this->assertEquals($output, $pofix->basename($input));
        } else {
            $this->assertEquals($output, $pofix->basename($input, $ext));
        }
    }


    public function provideExtname()
    {
        return array(
            array('foo.txt', '.txt'),
            array('/path/to/foo.txt', '.txt'),
            array('foo.bar.jpeg', '.jpeg'),
            array('foo.', '.'),
            array('foo', ''),

            array('.', ''),
            array('..', ''),
            array('...', '.'),
            array('/', ''),
            array('foo/', ''),
            array('foo/.', ''),
            array('foo/..', ''),
            array('foo/...', '.'),
        );
    }

    /**
     * @test
     * @dataProvider provideExtname
     */
    public function extname($input, $output)
    {
        $pofix = new Pofix();

        $this->assertEquals($output, $pofix->extname($input));
    }
}