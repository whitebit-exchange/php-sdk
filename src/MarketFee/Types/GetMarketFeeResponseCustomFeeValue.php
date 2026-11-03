<?php

namespace Whitebit\MarketFee\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMarketFeeResponseCustomFeeValue extends JsonSerializableType
{
    /**
     * @var ?string $taker Custom taker fee percentage for the market
     */
    #[JsonProperty('taker')]
    public ?string $taker;

    /**
     * @var ?string $maker Custom maker fee percentage for the market
     */
    #[JsonProperty('maker')]
    public ?string $maker;

    /**
     * @param array{
     *   taker?: ?string,
     *   maker?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->taker = $values['taker'] ?? null;
        $this->maker = $values['maker'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
