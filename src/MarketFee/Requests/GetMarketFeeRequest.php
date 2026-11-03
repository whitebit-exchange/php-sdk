<?php

namespace Whitebit\MarketFee\Requests;

use Whitebit\Core\Json\JsonSerializableType;

class GetMarketFeeRequest extends JsonSerializableType
{
    /**
     * @var ?string $market Optional. Currently ignored by the API — all market fees are returned regardless of the value provided. Retained for backward compatibility. Example: BTC_USDT
     */
    public ?string $market;

    /**
     * @param array{
     *   market?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
    }
}
