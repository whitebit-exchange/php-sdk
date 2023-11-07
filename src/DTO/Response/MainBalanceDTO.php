<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

final class MainBalanceDTO
{
    public function __construct(public string $ticker, public string $mainBalance)
    {
    }

    public static function fromResponseJson(string $ticker, array $data): self
    {
        return new self(
            $ticker,
            $data['main_balance']
        );
    }
}
