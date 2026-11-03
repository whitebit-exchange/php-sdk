<?php

namespace Whitebit\CollateralTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\CollateralTrading\Types\CreateCollateralMarketOrderRequestSide;
use Whitebit\CollateralTrading\Types\CreateCollateralMarketOrderRequestPositionSide;
use Whitebit\CollateralTrading\Types\CreateCollateralMarketOrderRequestStp;

class CreateCollateralMarketOrderRequest extends JsonSerializableType
{
    /**
     * @var string $market Available margin [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var value-of<CreateCollateralMarketOrderRequestSide> $side Order direction. Use `buy` to open or increase a long position and `sell` to open or increase a short position.
     */
    #[JsonProperty('side')]
    public string $side;

    /**
     * @var string $amount Amount of [stock](/glossary#stock) currency to buy or sell. Minimum and step values are market-dependent — query the [market info](/api-reference/market-data/market-info) endpoint for constraints.
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var ?string $clientOrderId Custom client order identifier. Uniqueness is enforced only among the account's open (pending) orders on the same market — once a previous order is filled or canceled, the same identifier can be reused, including on the same market. Contains only letters, numbers, dashes, dots, or underscores.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * Stop loss price.
     *
     * When provided, the system creates an [OTO](/glossary#one-triggers-the-other-oto) order with a stop loss condition.
     *
     * @var ?string $stopLoss
     */
    #[JsonProperty('stopLoss')]
    public ?string $stopLoss;

    /**
     * Take profit price.
     *
     * When provided, the system creates an [OTO](/glossary#one-triggers-the-other-oto) order with a take profit condition.
     *
     * @var ?string $takeProfit
     */
    #[JsonProperty('takeProfit')]
    public ?string $takeProfit;

    /**
     * Position direction. Optional at the request layer but functionally required when hedge mode is enabled. See [positionSide](/glossary#position-side).
     *
     * - **One-way mode** (default account mode): the field is ignored. Orders always use `BOTH`, and the response returns `positionSide: "BOTH"` whether the field is sent or omitted.
     * - **Hedge mode**: the field MUST be `LONG` or `SHORT`. Sending `BOTH`, omitting the field, or sending a value that does not match the account's mode causes the trade service to reject the order with error code `114` (`Hedge mode position side does not match`).
     *
     * @var ?value-of<CreateCollateralMarketOrderRequestPositionSide> $positionSide
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var ?bool $reduceOnly When `true`, the order can only reduce or close an existing position — the order cannot increase the position or open a new one. If the order amount exceeds the current position size, the system reduces the order to match — the response returns the adjusted amount. Cannot be combined with `stopLoss` or `takeProfit`. The API returns error code `116` if no open position exists or the order side matches the position direction. See [reduce-only](/glossary#reduce-only).
     */
    #[JsonProperty('reduceOnly')]
    public ?bool $reduceOnly;

    /**
     * Self-trade prevention mode. Allowed values: `no` (self-trades allowed), `cb` (cancel both the new and the existing order), `cn` (cancel the new order, keep the existing), `co` (cancel the existing order, place the new one). Default: `no`.
     *
     * Legacy values `cancel_both`, `cancel_new`, `cancel_old` are deprecated: the API accepts the legacy values with identical behavior until a deprecation deadline is announced, then rejects the legacy values. Responses always return the abbreviated form, regardless of which variant the request used.
     *
     * See [Self-Trade Prevention](/platform/self-trade-prevention).
     *
     * @var ?value-of<CreateCollateralMarketOrderRequestStp> $stp
     */
    #[JsonProperty('stp')]
    public ?string $stp;

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
     *   market: string,
     *   side: value-of<CreateCollateralMarketOrderRequestSide>,
     *   amount: string,
     *   request: string,
     *   nonce: int,
     *   clientOrderId?: ?string,
     *   stopLoss?: ?string,
     *   takeProfit?: ?string,
     *   positionSide?: ?value-of<CreateCollateralMarketOrderRequestPositionSide>,
     *   reduceOnly?: ?bool,
     *   stp?: ?value-of<CreateCollateralMarketOrderRequestStp>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->side = $values['side'];
        $this->amount = $values['amount'];
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->stopLoss = $values['stopLoss'] ?? null;
        $this->takeProfit = $values['takeProfit'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->reduceOnly = $values['reduceOnly'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
