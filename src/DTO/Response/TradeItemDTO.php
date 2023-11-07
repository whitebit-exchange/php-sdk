<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;

final readonly class TradeItemDTO
{
    public function __construct(
        public int $tradeId,
        public string $price,
        public string $quoteVolume,
        public string $baseVolume,
        public DateTimeInterface $tradedAt,
        public OrderTypeEnum $type,
    ) {
    }

    /**
     * @throws Exception
     */
    public static function fromResponseJson(array $data): self
    {
        return new self(
            $data['tradeID'],
            $data['price'],
            $data['quote_volume'],
            $data['base_volume'],
            DateTimeImmutable::createFromFormat('U', (string) $data['trade_timestamp']),
            OrderTypeEnum::from($data['type']),
        );
    }
}
