<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

final readonly class AssetLimitItemDTO
{
    public function __construct(
        public ?string $min,
        public ?string $max,
    ) {
    }

    public static function fromResponseJson(array $limit): self
    {
        return new self(
            $limit['min'] ?? null,
            $limit['max'] ?? null,
        );
    }
}
