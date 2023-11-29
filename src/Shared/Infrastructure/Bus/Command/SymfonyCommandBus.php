<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Command;

use Shared\Domain\Bus\Command\AsyncCommandInterface;
use Shared\Domain\Bus\Command\CommandBusInterface;
use Shared\Domain\Bus\Command\CommandInterface;
use Shared\Domain\Bus\Command\DelayedCommandInterface;
use Shared\Domain\Bus\Command\DispatchAfterCommandInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class SymfonyCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public function publish(CommandInterface $command): mixed
    {
        $async = $command instanceof AsyncCommandInterface;
        $stamps = [];

        if ($command instanceof DispatchAfterCommandInterface) {
            $stamps[] = new DispatchAfterCurrentBusStamp();
        }

        if ($command instanceof DelayedCommandInterface) {
            $stamps[] = new DelayStamp($command->getDelay());
        }

        if (\count($stamps) > 0) {
            $command = new Envelope($command, $stamps);
        }

        if (!$async) {
            return $this->handle($command);
        }

        $this->messageBus->dispatch($command);

        return null;
    }
}
