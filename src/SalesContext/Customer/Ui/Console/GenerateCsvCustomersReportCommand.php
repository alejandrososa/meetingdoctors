<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 20:43
 */

namespace MeetingDoctors\SalesContext\Customer\Ui\Console;

use MeetingDoctors\SalesContext\Customer\Application\Command\GenerateCsvCustomers;
use MeetingDoctors\SharedContext\Infrastructure\Bus\BusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCsvCustomersReportCommand  extends Command
{
    protected static $defaultName = 'app:reports:generate-csv-customers';

    /**
     * @var BusInterface
     */
    private $bus;

    public function __construct(BusInterface $bus, string $name = null)
    {
        parent::__construct($name);
        $this->bus = $bus;
    }

    protected function configure()
    {
        $this->setDescription('Generate report csv customers.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->bus->dispatch(new GenerateCsvCustomers());
            $output->writeln('<info>Report csv customer was created.</info>');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $output->writeln("<info>$message</info>");
            return Command::FAILURE;
        }
    }
}
