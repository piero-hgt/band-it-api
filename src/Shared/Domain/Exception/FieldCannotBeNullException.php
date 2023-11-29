<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

use Exception as BaseException;

class FieldCannotBeNullException extends BaseException implements Exception
{
    public static function fromEntityAndField(string $entity, string $field): self
    {
        return new self(sprintf('Field "%s" cannot be null on entity "%s"', $field, $entity));
    }
}
