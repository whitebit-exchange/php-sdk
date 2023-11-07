<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response\Private\Trade;

use WhiteBIT\Sdk\Enums\OrderTypeEnum;

final class SpotOrderDTO
{
    public function __construct(
        public int $orderId,
        public string $clientOrderId,
        public string $market,
        public OrderTypeEnum $side,
        public string $type, // TODO: make it enum
        public int $timestamp,
        public string $dealMoney,
        public string $dealStock,
        public string $amount,
        public string $takerFee,
        public string $makerFee,
        public string $left,
        public string $dealFee,
        public ?string $price,
        public bool $postOnly,
        public bool $ioc,
        public ?string $activationPrice,
    ) {
    }

    public static function fromResponseJson(array $data): self
    {
        return new self(
            $data['orderId'],
            $data['clientOrderId'],
            $data['market'],
            OrderTypeEnum::from($data['side']),
            $data['type'],
            $data['timestamp'],
            $data['dealMoney'],
            $data['dealStock'],
            $data['amount'],
            $data['takerFee'],
            $data['makerFee'],
            $data['left'],
            $data['dealFee'],
            $data['price'] ?? null,
            $data['postOnly'],
            $data['ioc'],
            $data['activation_price'] ?? null,
        );
    }
}
