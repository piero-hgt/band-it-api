<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Query;

use Shared\Domain\Bus\Query\QueryBusInterface;
use Shared\Domain\Bus\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class SymfonyQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function ask(QueryInterface $query): mixed
    {
        return $this->handle($query);
    }
}
