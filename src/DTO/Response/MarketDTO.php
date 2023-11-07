<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

use WhiteBIT\Sdk\Enums\MarketTypeEnum;

final readonly class MarketDTO
{
    public function __construct(
        public string $name,
        public string $stock,
        public string $money,
        public int $stockPrecision,
        public int $moneyPrecision,
        public int $feePrecision,
        public string $makerFee,
        public string $takerFee,
        public string $minAmount,
        public string $minTotal,
        public string $maxTotal,
        public bool $tradesEnabled,
        public bool $isCollateral,
        public MarketTypeEnum $type,
    ) {
    }

    public static function fromResponseJson(array $data): self
    {
        return new self(
            $data['name'],
            $data['stock'],
            $data['money'],
            (int) $data['stockPrec'],
            (int) $data['moneyPrec'],
            (int) $data['feePrec'],
            $data['makerFee'],
            $data['takerFee'],
            $data['minAmount'],
            $data['minTotal'],
            $data['maxTotal'],
            (bool) $data['tradesEnabled'],
            (bool) $data['isCollateral'],
            MarketTypeEnum::from($data['type']),
        );
    }
}
