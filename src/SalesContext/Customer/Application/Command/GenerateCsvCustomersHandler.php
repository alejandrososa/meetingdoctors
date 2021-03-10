<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 20:34
 */

namespace MeetingDoctors\SalesContext\Customer\Application\Command;

use MeetingDoctors\SalesContext\Customer\Infrastructure\Http\CustomerApiInterface;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\CustomerType;
use MeetingDoctors\SharedContext\Infrastructure\Filesystem\Reader\FileReaderInterface;
use MeetingDoctors\SharedContext\Infrastructure\Filesystem\Writer\FileWriterInterface;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerManagerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class GenerateCsvCustomersHandler implements MessageSubscriberInterface
{
    const CSV_REPORT_FILE = 'customers';
    const CSV_HEAD_ROW = [['Nombre', 'Email', 'Teléfono', 'Empresa']];

    private $customerApi;
    private $transformer;
    private $xmlReader;
    private $customerXmlProviderPath;
    private $customerCsvReportsDir;
    private $csvWriter;

    public function __construct(
        TransformerManagerInterface $transformer,
        CustomerApiInterface $customerApi,
        FileReaderInterface $xmlReader,
        FileWriterInterface $csvWriter,
        string $customerCsvReportsDir,
        string $customerXmlProviderPath
    ) {
        $this->transformer = $transformer;
        $this->customerApi = $customerApi;
        $this->xmlReader = $xmlReader;
        $this->csvWriter = $csvWriter;
        $this->customerXmlProviderPath = $customerXmlProviderPath;
        $this->customerCsvReportsDir = $customerCsvReportsDir;
    }

    public static function getHandledMessages(): iterable
    {
        yield GenerateCsvCustomers::class => [
            'bus' => 'command.bus',
            'from_transport' => 'sync'
        ];
    }

    public function __invoke(GenerateCsvCustomers $command)
    {
        $csvPath = $this->getCsvPath();
        $jsonContent = $this->getCustomersFromApi();
        $xmlContent = $this->getCustomersFromXml();


        $this->csvWriter->write($csvPath, array_merge(self::CSV_HEAD_ROW, $xmlContent, $jsonContent));
    }

    private function getCsvPath(): string
    {
        $file = self::CSV_REPORT_FILE;
        $suffix = date("Ymd", strtotime('now'));
        return sprintf('%s/%s-%s.csv', $this->customerCsvReportsDir, $file, $suffix);
    }

    private function getCustomersFromApi(): ?array
    {
        $content = $this->customerApi->fetchCustomers();

        return $this->transformer
            ->setType(CustomerType::JSON)
            ->setData($content)
            ->transform();
    }

    private function getCustomersFromXml(): ?array
    {
        $content = $this->xmlReader->read($this->customerXmlProviderPath);

        return $this->transformer
            ->setType(CustomerType::XML)
            ->setData($content)
            ->transform();
    }
}
