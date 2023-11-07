<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response\Private\Trade;

final class TradeBalanceDTO
{
    public function __construct(
        public string $ticker,
        public string $available,
        public string $freeze,
    ) {
    }

    public static function fromResponseJson(string $ticker, array $data): self
    {
        return new self(
            $ticker,
            $data['available'],
            $data['freeze'],
        );
    }
}
