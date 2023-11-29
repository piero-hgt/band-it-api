<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;
use Shared\Domain\ValueObject\File;

class FileType extends JsonType
{
    private const NAME = 'file';

    public function convertToDatabaseValue(
        /* @var File $value */
        $value,
        AbstractPlatform $platform
    ): ?string {
        if (null === $value) {
            return null;
        }

        try {
            $encoded = json_encode($value, \JSON_THROW_ON_ERROR);
            if (\JSON_ERROR_NONE !== json_last_error()) {
                throw ConversionException::conversionFailedSerialization($value, 'json', json_last_error_msg());
            }

            return $encoded;
        } catch (\JsonException $e) {
            throw ConversionException::conversionFailedSerialization($value, 'json', $e->getMessage());
        }
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?File
    {
        if (empty($value)) {
            return null;
        }

        if (\is_resource($value)) {
            $value = stream_get_contents($value);
        }

        try {
            $val = json_decode($value, true, 512, \JSON_THROW_ON_ERROR);
            if (\JSON_ERROR_NONE !== json_last_error()) {
                throw ConversionException::conversionFailed($value, $this->getName());
            }

            return File::fromArray($val);
        } catch (\JsonException $e) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
