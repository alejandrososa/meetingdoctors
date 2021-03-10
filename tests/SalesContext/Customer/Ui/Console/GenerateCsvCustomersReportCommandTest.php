<?php
/**
 * Ofertaski, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:29
 */

namespace MeetingDoctors\Tests\SalesContext\Customer\Ui\Console;

use MeetingDoctors\SalesContext\Customer\Ui\Console\GenerateCsvCustomersReportCommand;
use MeetingDoctors\Tests\SalesContext\Customer\CustomerIntegrationTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateCsvCustomersReportCommandTest extends CustomerIntegrationTestCase
{
    /**
     * @var Application
     */
    private $app;

    protected function setUp(): void
    {
        $this->app = new Application();
    }

    protected function tearDown(): void
    {
        $this->app = null;
    }

    protected function getCommand(): Command
    {
        $commandBus = $this->commandBus();
        $this->app->add(new GenerateCsvCustomersReportCommand($commandBus));
        return $this->app->find('app:reports:generate-csv-customers');
    }

    public function test_validate_exists_command()
    {
        $command = $this->getCommand();
        $this->assertInstanceOf(GenerateCsvCustomersReportCommand::class, $command);
    }

    public function test_execute_command()
    {
        $command = $this->getCommand();
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Report csv customer was created', $output);
    }
}
