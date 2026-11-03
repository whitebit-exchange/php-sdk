<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateCollateralBulkOrderRequestOrdersItem extends JsonSerializableType
{
    /**
     * @var ?string $market Available margin [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?value-of<CreateCollateralBulkOrderRequestOrdersItemSide> $side Order type. Variables: 'buy' / 'sell'.
     */
    #[JsonProperty('side')]
    public ?string $side;

    /**
     * @var ?string $amount Amount of [stock](/glossary#stock) currency to buy or sell. Minimum and step values are market-dependent — query the [market info](/api-reference/market-data/market-info) endpoint for constraints.
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $price Limit order price in [money](/glossary#money) currency. Minimum price step is market-dependent.
     */
    #[JsonProperty('price')]
    public ?string $price;

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
     * @var ?bool $postOnly Ensures the order adds liquidity and executes as maker. Default: `false`.
     */
    #[JsonProperty('postOnly')]
    public ?bool $postOnly;

    /**
     * Immediate-or-cancel (IOC) executes all or part of an order immediately and cancels any unfilled portion. Default: `false`.
     *
     * IOC does not support `rpi=true` because RPI uses post-only behavior by design.
     * The API returns error code `40` when an order item sets both `ioc=true` and `rpi=true`.
     *
     * @var ?bool $ioc
     */
    #[JsonProperty('ioc')]
    public ?bool $ioc;

    /**
     * Enables Retail Price Improvement (RPI) mode. Default: `false`.
     *
     * RPI orders use post-only behavior by design. An RPI order does not support `ioc=true`.
     * The API returns error code `40` when an order item sets both `rpi=true` and `ioc=true`.
     *
     * @var ?bool $rpi
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * Position direction. Optional at the request layer but functionally required when hedge mode is enabled. See [positionSide](/glossary#position-side).
     *
     * - **One-way mode** (default account mode): the field is ignored. Orders always use `BOTH`, and the response returns `positionSide: "BOTH"` whether the field is sent or omitted.
     * - **Hedge mode**: the field MUST be `LONG` or `SHORT`. Sending `BOTH`, omitting the field, or sending a value that does not match the account's mode causes the trade service to reject the per-order item with error code `114` (`Hedge mode position side does not match`).
     *
     * @var ?value-of<CreateCollateralBulkOrderRequestOrdersItemPositionSide> $positionSide
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var ?bool $reduceOnly When `true`, the order can only reduce or close an existing position — the order cannot increase the position or open a new one. If the order amount exceeds the current position size, the system reduces the order to match — the response returns the adjusted amount. Cannot be combined with `stopLoss` or `takeProfit`. The API returns error code `116` if no open position exists or the order side matches the position direction. See [reduce-only](/glossary#reduce-only).
     */
    #[JsonProperty('reduceOnly')]
    public ?bool $reduceOnly;

    /**
     * @param array{
     *   market?: ?string,
     *   side?: ?value-of<CreateCollateralBulkOrderRequestOrdersItemSide>,
     *   amount?: ?string,
     *   price?: ?string,
     *   clientOrderId?: ?string,
     *   stopLoss?: ?string,
     *   takeProfit?: ?string,
     *   postOnly?: ?bool,
     *   ioc?: ?bool,
     *   rpi?: ?bool,
     *   positionSide?: ?value-of<CreateCollateralBulkOrderRequestOrdersItemPositionSide>,
     *   reduceOnly?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->stopLoss = $values['stopLoss'] ?? null;
        $this->takeProfit = $values['takeProfit'] ?? null;
        $this->postOnly = $values['postOnly'] ?? null;
        $this->ioc = $values['ioc'] ?? null;
        $this->rpi = $values['rpi'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->reduceOnly = $values['reduceOnly'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
