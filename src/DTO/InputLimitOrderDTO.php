<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO;

use Saloon\Contracts\Arrayable;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;

final class InputLimitOrderDTO implements Arrayable
{
    public function __construct(
        public string $market,
        public OrderTypeEnum $side,
        public string $amount,
        public string $price,
        public ?bool $postOnly = null,
        public ?bool $ioc = null,
        public ?string $clientOrderId = null,
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'market' => $this->market,
            'side' => $this->side->value,
            'clientOrderId' => $this->clientOrderId,
            'amount' => $this->amount,
            'price' => $this->price,
            'postOnly' => $this->postOnly,
            'ioc' => $this->ioc,
        ], static fn (mixed $item): bool => $item !== null);
    }
}
