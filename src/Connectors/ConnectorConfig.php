<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Connectors;

final class ConnectorConfig
{
    public function __construct(
        public ?string $key = null,
        public ?string $secret = null,
        public ?string $baseUrl = 'https://whitebit.com',
        public ?int $timeout = 60,
    ) {
    }

    public function resolveNonce(): int
    {
        return (int) (microtime(true) * 1000);
    }
}
