<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

use Illuminate\Support\Collection;

final readonly class AssetLimitsDTO
{
    /**
     * @param  Collection<AssetProvidersDTO>|null  $deposit
     * @param  Collection<AssetProvidersDTO>|null  $withdraw
     */
    public function __construct(
        public ?Collection $deposit,
        public ?Collection $withdraw
    ) {
    }

    public static function fromResponseJson(array $limits): self
    {
        $deposit = (new Collection($limits['deposit']))->map(
            static fn (array $limit): \WhiteBIT\Sdk\DTO\Response\AssetLimitItemDTO => AssetLimitItemDTO::fromResponseJson($limit)
        );
        $withdraw = (new Collection($limits['withdraw']))->map(
            static fn (array $limit): \WhiteBIT\Sdk\DTO\Response\AssetLimitItemDTO => AssetLimitItemDTO::fromResponseJson($limit)
        );

        return new self(
            $deposit,
            $withdraw
        );
    }
}
