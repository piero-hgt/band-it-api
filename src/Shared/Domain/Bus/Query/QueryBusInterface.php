<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): mixed;
}
