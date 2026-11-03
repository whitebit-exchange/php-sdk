<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BorrowsUpdateParamsRecordsItem extends JsonSerializableType
{
    /**
     * @var ?string $asset Borrowed asset
     */
    #[JsonProperty('asset')]
    public ?string $asset;

    /**
     * @var ?float $ctime Borrow created date in Unix time
     */
    #[JsonProperty('ctime')]
    public ?float $ctime;

    /**
     * @var ?float $mtime Last update time in Unix time
     */
    #[JsonProperty('mtime')]
    public ?float $mtime;

    /**
     * @var ?string $amount Borrow amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $unrealizedFunding Funding to be paid on the next borrow stage change
     */
    #[JsonProperty('unrealized_funding')]
    public ?string $unrealizedFunding;

    /**
     * @var ?string $liqPrice Borrow liquidation price
     */
    #[JsonProperty('liq_price')]
    public ?string $liqPrice;

    /**
     * @param array{
     *   asset?: ?string,
     *   ctime?: ?float,
     *   mtime?: ?float,
     *   amount?: ?string,
     *   unrealizedFunding?: ?string,
     *   liqPrice?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->asset = $values['asset'] ?? null;
        $this->ctime = $values['ctime'] ?? null;
        $this->mtime = $values['mtime'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->unrealizedFunding = $values['unrealizedFunding'] ?? null;
        $this->liqPrice = $values['liqPrice'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
