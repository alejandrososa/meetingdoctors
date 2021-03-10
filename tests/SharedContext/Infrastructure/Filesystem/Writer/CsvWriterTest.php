<?php
/**
 * Ofertaski, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:32
 */

namespace MeetingDoctors\Tests\SharedContext\Infrastructure\Filesystem\Writer;

use MeetingDoctors\SharedContext\Infrastructure\Filesystem\Writer\CsvWriter;
use MeetingDoctors\Tests\Common\Infrastructure\PHPUnit\UnitTestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class CsvWriterTest extends UnitTestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('reports');
    }

    protected function tearDown(): void
    {
        $this->root = null;
    }

    public function test_the_file_must_contain_a_line_with_the_data_passed()
    {
        $file = vfsStream::newFile('customers.csv')->at($this->root);
        $data = [['Nombre', 'Email', 'Teléfono', 'Empresa']];
        $writer = new CsvWriter();
        $writer->write($file->url(), $data);
        $this->assertStringContainsString('Nombre,Email,Teléfono,Empresa', $file->getContent());
    }
}
