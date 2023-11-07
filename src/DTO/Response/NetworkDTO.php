<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

final readonly class NetworkDTO
{
    public function __construct(
        public ?string $default = null,
        public array $deposits = [],
        public array $withdraws = []
    ) {
    }

    public static function fromResponseJson(array $networks): self
    {
        return new self(
            $networks['default'] ?? null,
            $networks['deposits'] ?? [],
            $networks['withdraws'] ?? [],
        );
    }
}
