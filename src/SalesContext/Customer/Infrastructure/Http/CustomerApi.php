<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 16:25
 */

namespace MeetingDoctors\SalesContext\Customer\Infrastructure\Http;

use MeetingDoctors\SalesContext\Customer\Application\Exception\ErrorJsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerApi implements CustomerApiInterface
{
    private $client;
    private $customerApiBaseUrl;

    public function __construct(HttpClientInterface $client, string $customerApiBaseUrl)
    {
        $this->client = $client;
        $this->customerApiBaseUrl = $customerApiBaseUrl;
    }

    public function fetchCustomers(): ?string
    {
        try {
            $url = $this->customerApiBaseUrl . '/users';
            $response = $this->client->request('GET', $url);
            if ($response->getStatusCode() !== Response::HTTP_OK) {
                throw new ErrorJsonResponse();
            }
            return $response->getContent();
        } catch (\Throwable $e) {
            throw new ErrorJsonResponse($e->getMessage());
        }
    }
}
