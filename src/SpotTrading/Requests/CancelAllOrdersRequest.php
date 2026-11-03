<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SpotTrading\Types\CancelAllOrdersRequestTypeItem;
use Whitebit\Core\Types\ArrayType;
use Whitebit\SpotTrading\Types\CancelAllOrdersRequestPositionSide;

class CancelAllOrdersRequest extends JsonSerializableType
{
    /**
     * @var ?string $market Available [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?array<value-of<CancelAllOrdersRequestTypeItem>> $type Order types to target. Valid values: "spot" — standard spot orders. "margin" — marginal orders placed on spot markets. Note: the "margin" value is not the same as the collateral account balance; "collateral" in other endpoints refers to the funding account, whereas "margin" here refers specifically to the order type. "futures" — marginal orders placed on futures markets (e.g., BTC_PERP). If omitted, the API targets all order types.
     */
    #[JsonProperty('type'), ArrayType(['string'])]
    public ?array $type;

    /**
     * @var ?value-of<CancelAllOrdersRequestPositionSide> $positionSide [Position side](/glossary#position-side) scope. Accepted only when `market` is a perpetual futures market (e.g., BTC_PERP); values are lowercase on this endpoint.
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

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
     *   request: string,
     *   nonce: int,
     *   market?: ?string,
     *   type?: ?array<value-of<CancelAllOrdersRequestTypeItem>>,
     *   positionSide?: ?value-of<CancelAllOrdersRequestPositionSide>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
