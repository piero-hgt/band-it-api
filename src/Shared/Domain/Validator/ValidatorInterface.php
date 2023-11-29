<?php

declare(strict_types=1);

namespace Shared\Domain\Validator;

interface ValidatorInterface
{
    /**
     * @throws \RuntimeException
     */
    public function validate(object $data, array $context = []): void;
}
