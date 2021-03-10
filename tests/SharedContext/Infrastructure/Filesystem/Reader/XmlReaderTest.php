<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:32
 */

namespace MeetingDoctors\Tests\SharedContext\Infrastructure\Filesystem\Reader;

use MeetingDoctors\SharedContext\Infrastructure\Filesystem\Reader\XmlReader;
use MeetingDoctors\Tests\Common\Infrastructure\PHPUnit\UnitTestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class XmlReaderTest extends UnitTestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('config/providers');
    }

    protected function tearDown(): void
    {
        $this->root = null;
    }

    public function test_must_return_null_if_there_is_an_XML_file()
    {
        $reader = new XmlReader();
        $this->assertNull($reader->read('file_no_exist.xml'));
    }

    public function test_must_return_an_object_if_there_is_an_XML_file()
    {
        $file = vfsStream::newFile('data.xml')
            ->withContent('<?xml version="1.0"?><tag>Hi</tag>')
            ->at($this->root);

        $reader = new XmlReader();
        $this->assertInstanceOf(\SimpleXMLElement::class, $reader->read($file->url()));
    }
}
