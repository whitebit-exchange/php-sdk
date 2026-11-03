<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SpotTrading\Types\StopLimitOrderRequestSide;
use Whitebit\SpotTrading\Types\StopLimitOrderRequestStp;

class StopLimitOrderRequest extends JsonSerializableType
{
    /**
     * @var string $market Trading pair. Format: `BASE_QUOTE` (e.g., `BTC_USDT`). Query `GET /api/v4/public/markets` for available markets.
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var value-of<StopLimitOrderRequestSide> $side Order side. Allowed values: `buy`, `sell`.
     */
    #[JsonProperty('side')]
    public string $side;

    /**
     * @var string $amount Order quantity in base (stock) currency. Minimum and maximum values are market-dependent. Query `GET /api/v4/public/markets` for `minAmount`, `minTotal`, `maxTotal`. Precision: `stockPrec`.
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var ?string $price Limit price per unit in quote (money) currency applied after the stop triggers. Required unless `bboRole` is set — the BBO execution method replaces the explicit price. Minimum and maximum values are market-dependent. Precision: `moneyPrec`.
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var string $activationPrice Trigger price in quote (money) currency. For buy orders, the stop triggers when the market price rises to or above the specified price. For sell orders, the stop triggers when the market price falls to or below the specified price. Precision: `moneyPrec`.
     */
    #[JsonProperty('activation_price')]
    public string $activationPrice;

    /**
     * @var ?string $clientOrderId Custom client order identifier. Uniqueness is enforced only among the account's open (pending) orders on the same market — once a previous order is filled or canceled, the same identifier can be reused, including on the same market. Contains only letters, numbers, dashes, dots, or underscores.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * @var ?int $bboRole Best Bid/Offer ([BBO](/glossary#best-bid-offer-bbo)) execution method. The system selects the best market price for execution after the stop triggers. `1` = Queue method, `2` = Counterparty method. When `bboRole` is set, `price` is not required — the BBO method determines the execution price.
     */
    #[JsonProperty('bboRole')]
    public ?int $bboRole;

    /**
     * Self-trade prevention mode. Allowed values: `no` (self-trades allowed), `cb` (cancel both the new and the existing order), `cn` (cancel the new order, keep the existing), `co` (cancel the existing order, place the new one). Default: `no`.
     *
     * Legacy values `cancel_both`, `cancel_new`, `cancel_old` are deprecated: the API accepts the legacy values with identical behavior until a deprecation deadline is announced, then rejects the legacy values. Responses always return the abbreviated form, regardless of which variant the request used.
     *
     * See [Self-Trade Prevention](/platform/self-trade-prevention).
     *
     * @var ?value-of<StopLimitOrderRequestStp> $stp
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
     *   side: value-of<StopLimitOrderRequestSide>,
     *   amount: string,
     *   activationPrice: string,
     *   request: string,
     *   nonce: int,
     *   price?: ?string,
     *   clientOrderId?: ?string,
     *   bboRole?: ?int,
     *   stp?: ?value-of<StopLimitOrderRequestStp>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->side = $values['side'];
        $this->amount = $values['amount'];
        $this->price = $values['price'] ?? null;
        $this->activationPrice = $values['activationPrice'];
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->bboRole = $values['bboRole'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
