<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

class File implements \JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        public readonly FileType $type,
        public readonly int $size
    ) {
    }

    public static function fromArray(array $array): self
    {
        return new self(
            $array['name'],
            $array['path'],
            FileType::from($array['type']),
            $array['size']
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'type' => $this->type->value,
            'size' => $this->size,
        ];
    }
}
