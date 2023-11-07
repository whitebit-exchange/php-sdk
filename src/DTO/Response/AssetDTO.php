<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

final readonly class AssetDTO
{
    public bool $isFiat;

    public function __construct(
        public string $market,
        public string $name,
        public int $unifiedCryptoAssetId,
        public bool $canWithdraw,
        public bool $canDeposit,
        public string $minWithdraw,
        public string $maxWithdraw,
        public string $makerFee,
        public string $takerFee,
        public string $minDeposit,
        public string $maxDeposit,
        public int $currencyPrecision,
        public bool $isMemo,
        public ?NetworkDTO $networks,
        public ?AssetLimitsDTO $limits,
        public ?AssetProvidersDTO $providers,
    ) {
        $this->isFiat = ! $this->networks instanceof \WhiteBIT\Sdk\DTO\Response\NetworkDTO;
    }

    public static function fromResponseJson(string $marketName, array $data): self
    {
        $networks = $data['networks'] ?? null;
        $limits = $data['limits'] ?? null;
        $providers = $data['providers'] ?? null;

        return new self(
            $marketName,
            $data['name'],
            $data['unified_cryptoasset_id'],
            $data['can_withdraw'],
            $data['can_deposit'],
            $data['min_withdraw'],
            $data['max_withdraw'],
            $data['maker_fee'],
            $data['taker_fee'],
            $data['min_deposit'],
            $data['max_deposit'],
            $data['currency_precision'],
            $data['is_memo'],
            $networks ? NetworkDTO::fromResponseJson($networks) : null,
            $limits ? AssetLimitsDTO::fromResponseJson($limits) : null,
            $providers ? AssetProvidersDTO::fromResponseJson($providers) : null,
        );
    }
}
