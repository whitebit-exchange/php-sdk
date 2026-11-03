<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetOpenPositionsResponseItem extends JsonSerializableType
{
    /**
     * @var ?int $positionId Unique position identifier
     */
    #[JsonProperty('positionId')]
    public ?int $positionId;

    /**
     * @var ?string $market Market name
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $amount Position amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $basePrice Base price of position
     */
    #[JsonProperty('basePrice')]
    public ?string $basePrice;

    /**
     * @var ?string $pnl Realized profit and loss accumulated from partial position closes, in money currency. Zero for newly opened positions that have not been partially closed.
     */
    #[JsonProperty('pnl')]
    public ?string $pnl;

    /**
     * @var ?string $pnlPercent Unrealized profit and loss in percentage
     */
    #[JsonProperty('pnlPercent')]
    public ?string $pnlPercent;

    /**
     * @var ?string $margin Amount of funds in open position money
     */
    #[JsonProperty('margin')]
    public ?string $margin;

    /**
     * @var ?string $freeMargin Free funds for trading
     */
    #[JsonProperty('freeMargin')]
    public ?string $freeMargin;

    /**
     * @var ?string $funding Cumulative funding fees paid over the entire lifetime of the position, in money currency. For futures markets (e.g., BTC_PERP and other _PERP pairs), the value is always "0" — futures funding is applied via periodic balance updates rather than being tracked per position.
     */
    #[JsonProperty('funding')]
    public ?string $funding;

    /**
     * @var ?string $unrealizedPnl Floating (mark-to-market) unrealized profit and loss in money currency. Updates continuously as the market price changes.
     */
    #[JsonProperty('unrealizedPnl')]
    public ?string $unrealizedPnl;

    /**
     * @var ?value-of<GetOpenPositionsResponseItemPositionSide> $positionSide Position side
     */
    #[JsonProperty('positionSide')]
    public ?string $positionSide;

    /**
     * @var ?float $openDate Date of position opening in Unix timestamp format
     */
    #[JsonProperty('openDate')]
    public ?float $openDate;

    /**
     * @var ?float $modifyDate Date of position modifying (current event) in Unix timestamp format
     */
    #[JsonProperty('modifyDate')]
    public ?float $modifyDate;

    /**
     * @var ?string $liquidationPrice Liquidation price according to current state of position
     */
    #[JsonProperty('liquidationPrice')]
    public ?string $liquidationPrice;

    /**
     * @var ?value-of<GetOpenPositionsResponseItemLiquidationState> $liquidationState State of liquidation
     */
    #[JsonProperty('liquidationState')]
    public ?string $liquidationState;

    /**
     * @var ?GetOpenPositionsResponseItemTpsl $tpsl Take profit and stop loss configuration
     */
    #[JsonProperty('tpsl')]
    public ?GetOpenPositionsResponseItemTpsl $tpsl;

    /**
     * @var ?string $unrealizedFunding Funding fees accrued since the last position state change and not yet realized. For margin positions, the value accumulates continuously and is settled into the funding field when the position state changes (e.g., on partial or full close). For futures markets (BTC_PERP and other _PERP pairs), always "0" — futures funding is applied via periodic balance updates, not tracked per position.
     */
    #[JsonProperty('unrealizedFunding')]
    public ?string $unrealizedFunding;

    /**
     * @param array{
     *   positionId?: ?int,
     *   market?: ?string,
     *   amount?: ?string,
     *   basePrice?: ?string,
     *   pnl?: ?string,
     *   pnlPercent?: ?string,
     *   margin?: ?string,
     *   freeMargin?: ?string,
     *   funding?: ?string,
     *   unrealizedPnl?: ?string,
     *   positionSide?: ?value-of<GetOpenPositionsResponseItemPositionSide>,
     *   openDate?: ?float,
     *   modifyDate?: ?float,
     *   liquidationPrice?: ?string,
     *   liquidationState?: ?value-of<GetOpenPositionsResponseItemLiquidationState>,
     *   tpsl?: ?GetOpenPositionsResponseItemTpsl,
     *   unrealizedFunding?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->positionId = $values['positionId'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->basePrice = $values['basePrice'] ?? null;
        $this->pnl = $values['pnl'] ?? null;
        $this->pnlPercent = $values['pnlPercent'] ?? null;
        $this->margin = $values['margin'] ?? null;
        $this->freeMargin = $values['freeMargin'] ?? null;
        $this->funding = $values['funding'] ?? null;
        $this->unrealizedPnl = $values['unrealizedPnl'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
        $this->openDate = $values['openDate'] ?? null;
        $this->modifyDate = $values['modifyDate'] ?? null;
        $this->liquidationPrice = $values['liquidationPrice'] ?? null;
        $this->liquidationState = $values['liquidationState'] ?? null;
        $this->tpsl = $values['tpsl'] ?? null;
        $this->unrealizedFunding = $values['unrealizedFunding'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
