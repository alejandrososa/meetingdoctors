<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:56
 */

namespace MeetingDoctors\Tests\SalesContext\Customer;

use MeetingDoctors\SalesContext\Customer\Application\Exception\ErrorJsonResponse;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Http\CustomerApi;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Http\CustomerApiInterface;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\CustomerType;
use MeetingDoctors\Tests\Common\Infrastructure\PHPUnit\IntegrationTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class CustomerIntegrationTestCase extends IntegrationTestCase
{
    private $customerApi;

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->customerApi = null;
    }

    /** @return CustomerApiInterface|MockObject */
    protected function customerApi()
    {
        return $this->customerApi = new CustomerApi($this->httpClient(), 'http://fakedomain.es');
    }

    //helpers method
    protected function apiCustomerShouldThrowErrorResponse(): MockHttpClient
    {
        return $this->httpClient = new MockHttpClient([
            new MockResponse('Error', ['http_code' => 500]),
        ]);
    }

    protected function apiCustomerShouldReturnResponse(array $data = []): MockHttpClient
    {
        return $this->httpClient = new MockHttpClient([
            new MockResponse(json_encode($data)),
        ]);
    }

    protected function transformerManagerShouldReturnContentByType(string $type, $content): void
    {
        $this->transformerManager()
            ->method('setType')
            ->with($this->equalTo(CustomerType::JSON))
            ->willReturnSelf();

        $this->transformerManager()
            ->method('setData')
            ->with($this->equalTo($content))
            ->willReturnSelf();
    }
}
