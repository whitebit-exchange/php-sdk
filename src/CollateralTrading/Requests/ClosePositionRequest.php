<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\CollateralTrading\Types\ClosePositionRequestPositionSide;

class ClosePositionRequest extends JsonSerializableType
{
    /**
     * @var int $positionId Unique identifier of the position to close. Obtain from the [open positions](/api-reference/collateral-trading/open-positions) endpoint.
     */
    #[JsonProperty('positionId')]
    public int $positionId;

    /**
     * @var ?value-of<ClosePositionRequestPositionSide> $positionSide Defines the position direction when hedge mode is enabled. See [positionSide](/glossary#position-side)
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var string $market Market of the position to close. Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var string $request
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   positionId: int,
     *   market: string,
     *   request: string,
     *   nonce: int,
     *   positionSide?: ?value-of<ClosePositionRequestPositionSide>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->positionId = $values['positionId'];
        $this->positionSide = $values['positionSide'] ?? null;
        $this->market = $values['market'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
