<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 20:38
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Bus;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class Bus implements BusInterface
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;
    /**
     * @var MessageBusInterface
     */
    private $queryBus;

    public function __construct(
        MessageBusInterface $commandBus,
        MessageBusInterface $queryBus,
        MessageBusInterface $eventBus
    ) {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->queryBus = $queryBus;
    }

    /**
     * Execute a command.
     * @param $commandRequest
     */
    public function dispatch($commandRequest): void
    {
        $this->commandBus->dispatch($commandRequest);
    }

    /**
     * Do a data query.
     * @param $queryRequest
     * @return null
     */
    public function ask($queryRequest)
    {
        $envelope = $this->queryBus->dispatch($queryRequest);
        $handledStamp = $envelope->last(HandledStamp::class);
        return $handledStamp->getResult() ?? null;
    }

    /**
     * Notifies that an action has occurred.
     * @param $eventRequest
     * @param bool $delay
     */
    public function notify($eventRequest, bool $delay = false): void
    {
        $options = $delay ? [new DelayStamp(self::DELAY)] : [];
        $this->eventBus->dispatch((new Envelope($eventRequest)), $options)
            ->with(new DispatchAfterCurrentBusStamp());
    }
}
