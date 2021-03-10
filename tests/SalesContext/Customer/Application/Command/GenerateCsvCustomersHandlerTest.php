<?php
/**
 * Ofertaski, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:26
 */

namespace MeetingDoctors\Tests\SalesContext\Customer\Application\Command;

use MeetingDoctors\SalesContext\Customer\Application\Command\GenerateCsvCustomers;
use MeetingDoctors\SalesContext\Customer\Application\Command\GenerateCsvCustomersHandler;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\Exception\InvalidJsonResponse;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\Exception\InvalidXmlData;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\JsonCustomerTransformer;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\XmlCustomerTransformer;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerManager;
use MeetingDoctors\Tests\SalesContext\Customer\CustomerIntegrationTestCase;

class GenerateCsvCustomersHandlerTest extends CustomerIntegrationTestCase
{
    /**
     * @var GenerateCsvCustomersHandler
     */
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->handler = null;
    }

    private function createHandler()
    {
        $this->transformerFactoryShouldReturn([new JsonCustomerTransformer(), new XmlCustomerTransformer()]);

        return new GenerateCsvCustomersHandler(
            new TransformerManager($this->transformerFactory()),
            $this->customerApi(),
            $this->xmlReader(),
            $this->csvWriter(),
            '',
            ''
        );
    }

    /**
     * @return array
     */
    protected function getJson(): array
    {
        return [
            [
                'id' => 1,
                "name" => "Clementine Bauch",
                "email" => "Nathan@yesenia.net",
                "phone" => "1-463-123-4447",
                "website" => "ramiro.info",
                "company" => [
                    "name" => "Romaguera-Jacobson",
                ]
            ]
        ];
    }

    public function test_throw_an_exception_if_httpclient_return_bad_response()
    {
        $this->expectException(InvalidJsonResponse::class);

        $this->apiCustomerShouldReturnResponse([]);

        $this->handler = $this->createHandler();
        $this->handler->__invoke(new GenerateCsvCustomers());
    }

    public function test_throw_an_exception_if_xml_return_is_not_valid()
    {
        $this->expectException(InvalidXmlData::class);

        $xml = '<?xml version="1.0"?><errors></errors>';
        $json = $this->getJson();

        $this->apiCustomerShouldReturnResponse($json);
        $this->xmlReaderShouldHasContent($xml);

        $this->handler = $this->createHandler();
        $this->handler->__invoke(new GenerateCsvCustomers());
    }

    public function test_it_can_create_csv()
    {
        $xml = '<?xml version="1.0"?>
        <readings>
            <reading clientID="1" name="Taylor Glover" phone="463-170-9623 x156" company="Cargill">Taylor.Glover@gmail.com</reading>
        </readings>';

        $json = $this->getJson();

        $this->apiCustomerShouldReturnResponse($json);
        $this->xmlReaderShouldHasContent($xml);
        $this->csvFileWriterShouldCreateAFile();

        $this->handler = $this->createHandler();
        $this->handler->__invoke(new GenerateCsvCustomers());
    }
}
