<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BulkOrderItem extends JsonSerializableType
{
    /**
     * @var value-of<BulkOrderItemSide> $side Order side. Allowed values: `buy`, `sell`.
     */
    #[JsonProperty('side')]
    public string $side;

    /**
     * @var string $amount Order quantity in base (stock) currency. Minimum and maximum values are market-dependent. Query `GET /api/v4/public/markets` for `minAmount` and precision (`stockPrec`).
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var ?string $price Limit price per unit in quote (money) currency. Required unless `bboRole` is set — the BBO execution method replaces the explicit price. Minimum and maximum values are market-dependent. Query `GET /api/v4/public/markets` for precision (`moneyPrec`).
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var string $market Trading pair for the order. Format: `BASE_QUOTE` (e.g., `BTC_USDT`).
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var ?bool $postOnly Post-only flag. When `true`, the order executes only as a maker order and is rejected if it would match immediately. Allowed only when `bboRole` is not set. Do not combine with `rpi=true` — RPI items apply post-only behavior automatically, and an item setting both flags fails validation. Default: `false`.
     */
    #[JsonProperty('postOnly')]
    public ?bool $postOnly;

    /**
     * Immediate-or-cancel (IOC) executes all or part of an order immediately and cancels any unfilled portion. Default: `false`.
     *
     * IOC does not support `rpi=true` because RPI uses post-only behavior by design.
     * The API returns error code `40` when an order item sets both `ioc=true` and `rpi=true`.
     * IOC cannot be combined with `postOnly=true` (error code `37`), and with `bboRole` it is allowed only for the Counterparty method (`2`).
     *
     * @var ?bool $ioc
     */
    #[JsonProperty('ioc')]
    public ?bool $ioc;

    /**
     * @var ?string $clientOrderId Custom client order identifier. Uniqueness is enforced only among the account's open (pending) orders on the same market — once a previous order is filled or canceled, the same identifier can be reused, including on the same market. Contains only letters, numbers, dashes, dots, or underscores.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * Best Bid/Offer ([BBO](/glossary#best-bid-offer-bbo)) execution method for the item. The system selects the best market price for execution. `1` = Queue method, `2` = Counterparty method.
     *
     * When `bboRole` is set, the item's `price` is not required — the BBO method determines the execution price. `postOnly` is allowed only when `bboRole` is not set; `ioc` can be combined only with the Counterparty method (`2`).
     *
     * @var ?int $bboRole
     */
    #[JsonProperty('bboRole')]
    public ?int $bboRole;

    /**
     * Self-trade prevention mode for the item. Allowed values: `no` (self-trades allowed), `cb` (cancel both the new and the existing order), `cn` (cancel the new order, keep the existing), `co` (cancel the existing order, place the new one). Default: `no`.
     *
     * Legacy values `cancel_both`, `cancel_new`, `cancel_old` are deprecated: the API accepts the legacy values with identical behavior until a deprecation deadline is announced, then rejects the legacy values. Responses always return the abbreviated form, regardless of which variant the request used.
     *
     * See [Self-Trade Prevention](/platform/self-trade-prevention).
     *
     * @var ?value-of<BulkOrderItemStp> $stp
     */
    #[JsonProperty('stp')]
    public ?string $stp;

    /**
     * Enables Retail Price Improvement (RPI) mode. Default: `false`.
     *
     * RPI items apply post-only behavior automatically — do not also send an explicit `postOnly=true`: an item combining the two flags fails validation. An RPI order does not support `ioc=true`.
     * The API returns error code `40` when an order item sets both `rpi=true` and `ioc=true`.
     *
     * @var ?bool $rpi
     */
    #[JsonProperty('rpi')]
    public ?bool $rpi;

    /**
     * Retail-source taker flag for the bulk-order item. When `true`, the item is eligible to match against orders submitted by RPI makers and may receive price improvement at execution. Default: `false`.
     *
     * The Retail flag must be enabled on the account before a private-API request can set `retail=true`. Contact the account manager to enable the Retail flag.
     *
     * The Retail flag cannot be combined with `rpi`. The API returns error code `41` when an item sets both `retail=true` and `rpi=true`.
     *
     * The flag has no effect on a `postOnly=true` item. Post-only orders are [makers](/glossary#maker); only takers carry the retail designation.
     *
     * Refer to [Retail flag](/glossary#retail-flag) and [Order Parameter Rules](/guides/order-parameter-rules) for unsupported parameter combinations.
     *
     * @var ?bool $retail
     */
    #[JsonProperty('retail')]
    public ?bool $retail;

    /**
     * @param array{
     *   side: value-of<BulkOrderItemSide>,
     *   amount: string,
     *   market: string,
     *   price?: ?string,
     *   postOnly?: ?bool,
     *   ioc?: ?bool,
     *   clientOrderId?: ?string,
     *   bboRole?: ?int,
     *   stp?: ?value-of<BulkOrderItemStp>,
     *   rpi?: ?bool,
     *   retail?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->side = $values['side'];
        $this->amount = $values['amount'];
        $this->price = $values['price'] ?? null;
        $this->market = $values['market'];
        $this->postOnly = $values['postOnly'] ?? null;
        $this->ioc = $values['ioc'] ?? null;
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->bboRole = $values['bboRole'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->rpi = $values['rpi'] ?? null;
        $this->retail = $values['retail'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
