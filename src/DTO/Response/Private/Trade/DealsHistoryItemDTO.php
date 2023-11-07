<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response\Private\Trade;

use WhiteBIT\Sdk\Enums\OrderTypeEnum;

final class DealsHistoryItemDTO
{
    public function __construct(
        public string $market,
        public int $id,
        public float $time,
        public OrderTypeEnum $side,
        public int $role, // TODO: move to enum
        public string $amount,
        public string $price,
        public string $deal,
        public string $fee,
        public string $clientOrderId,
    ) {
    }

    public static function fromResponseJson(string $market, array $data): self
    {
        return new self(
            $market,
            $data['id'],
            $data['time'],
            OrderTypeEnum::from($data['side']),
            $data['role'],
            $data['amount'],
            $data['price'],
            $data['deal'],
            $data['fee'],
            $data['clientOrderId'],
        );
    }
}
