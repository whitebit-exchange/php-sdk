<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SpotTrading\Types\MarketOrderRequestSide;
use Whitebit\SpotTrading\Types\MarketOrderRequestStp;

class MarketOrderRequest extends JsonSerializableType
{
    /**
     * @var string $market Trading pair. Format: `BASE_QUOTE` (e.g., `BTC_USDT`). Query `GET /api/v4/public/markets` for available markets.
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var value-of<MarketOrderRequestSide> $side Order side. Allowed values: `buy`, `sell`.
     */
    #[JsonProperty('side')]
    public string $side;

    /**
     * @var string $amount For buy orders: total in quote (money) currency to spend. For sell orders: quantity in base (stock) currency to sell. Minimum and maximum values are market-dependent. Query `GET /api/v4/public/markets` for `minAmount`, `minTotal`, `maxTotal`.
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var ?string $clientOrderId Custom client order identifier. Uniqueness is enforced only among the account's open (pending) orders on the same market — once a previous order is filled or canceled, the same identifier can be reused, including on the same market. Contains only letters, numbers, dashes, dots, or underscores.
     */
    #[JsonProperty('clientOrderId')]
    public ?string $clientOrderId;

    /**
     * Self-trade prevention mode. Allowed values: `no` (self-trades allowed), `cb` (cancel both the new and the existing order), `cn` (cancel the new order, keep the existing), `co` (cancel the existing order, place the new one). Default: `no`.
     *
     * Legacy values `cancel_both`, `cancel_new`, `cancel_old` are deprecated: the API accepts the legacy values with identical behavior until a deprecation deadline is announced, then rejects the legacy values. Responses always return the abbreviated form, regardless of which variant the request used.
     *
     * See [Self-Trade Prevention](/platform/self-trade-prevention).
     *
     * @var ?value-of<MarketOrderRequestStp> $stp
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
     *   side: value-of<MarketOrderRequestSide>,
     *   amount: string,
     *   request: string,
     *   nonce: int,
     *   clientOrderId?: ?string,
     *   stp?: ?value-of<MarketOrderRequestStp>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->side = $values['side'];
        $this->amount = $values['amount'];
        $this->clientOrderId = $values['clientOrderId'] ?? null;
        $this->stp = $values['stp'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
