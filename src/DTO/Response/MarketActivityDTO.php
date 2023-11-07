<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

final readonly class MarketActivityDTO
{
    public function __construct(
        public string $market,
        public int $baseId,
        public int $quoteId,
        public string $lastPrice,
        public string $quoteVolume,
        public string $baseVolume,
        public bool $isFrozen,
        public string $change,
    ) {
    }

    public static function fromResponseJson(string $marketName, array $data): self
    {
        return new self(
            $marketName,
            $data['base_id'],
            $data['quote_id'],
            $data['last_price'],
            $data['quote_volume'],
            $data['base_volume'],
            $data['isFrozen'],
            $data['change'],
        );
    }
}
