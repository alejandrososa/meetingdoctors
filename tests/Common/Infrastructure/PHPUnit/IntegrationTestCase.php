<?php
/**
 * Ofertaski, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:51
 */

namespace MeetingDoctors\Tests\Common\Infrastructure\PHPUnit;

use Faker\Factory;
use Faker\Generator;
use MeetingDoctors\SharedContext\Infrastructure\Bus\BusInterface;
use MeetingDoctors\SharedContext\Infrastructure\Filesystem\Reader\FileReaderInterface;
use MeetingDoctors\SharedContext\Infrastructure\Filesystem\Writer\FileWriterInterface;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerFactoryInterface;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class IntegrationTestCase extends TestCase
{
    private $fake;
    private $commandBus;
    private $transformerFactory;
    private $transformerManager;
    private $xmlReader;
    private $csvWriter;
    protected $httpClient;

    protected function tearDown(): void
    {
        $this->fake = null;
        $this->commandBus = null;
        $this->transformerFactory = null;
        $this->transformerManager = null;
        $this->xmlReader = null;
        $this->csvWriter = null;
        $this->httpClient = null;
    }

    //instances
    /** @return Generator */
    protected function fake(): Generator
    {
        return $this->fake = $this->fake ?: Factory::create('es_ES');
    }

    protected function mock($className): MockObject
    {
        return $this->createMock($className);
    }

    /** @return BusInterface|MockObject */
    protected function commandBus()
    {
        return $this->commandBus = $this->commandBus ?: $this->mock(BusInterface::class);
    }

    /** @return TransformerFactoryInterface|MockObject */
    protected function transformerFactory()
    {
        return $this->transformerFactory = $this->transformerFactory ?: $this->mock(TransformerFactoryInterface::class);
    }

    /** @return TransformerManagerInterface|MockObject */
    protected function transformerManager()
    {
        return $this->transformerManager = $this->transformerManager ?: $this->mock(TransformerManagerInterface::class);
    }

    /** @return FileReaderInterface|MockObject */
    protected function xmlReader()
    {
        return $this->xmlReader = $this->xmlReader ?: $this->mock(FileReaderInterface::class);
    }

    /** @return FileWriterInterface|MockObject */
    protected function csvWriter()
    {
        return $this->csvWriter = $this->csvWriter ?: $this->mock(FileWriterInterface::class);
    }

    /** @return HttpClientInterface|MockObject */
    protected function httpClient()
    {
        return $this->httpClient = $this->httpClient?: new MockHttpClient(
            new MockResponse(json_encode([]))
        );
    }

    //helpers method
    protected function xmlReaderShouldHasContent($xml): void
    {
        $this->xmlReader()
            ->expects($this->atLeastOnce())
            ->method('read')
            ->will($this->returnValue(new \SimpleXMLElement($xml)));
    }

    protected function csvFileWriterShouldCreateAFile(): void
    {
        $this->csvWriter()
            ->expects($this->once())
            ->method('write');
    }

    protected function transformerFactoryShouldReturn(array $transformers): void
    {
        $this->transformerFactory()
            ->expects($this->atLeastOnce())
            ->method('strategies')
            ->will($this->returnValue($transformers));
    }
}
