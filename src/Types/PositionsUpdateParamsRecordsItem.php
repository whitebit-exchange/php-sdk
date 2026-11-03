<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class PositionsUpdateParamsRecordsItem extends JsonSerializableType
{
    /**
     * @var ?int $id Position ID
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?string $market [Market](/glossary#market) name
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?float $ctime Date of position opening in Unix time
     */
    #[JsonProperty('ctime')]
    public ?float $ctime;

    /**
     * @var ?float $mtime Date of position modification (the date of the current event) in Unix time
     */
    #[JsonProperty('mtime')]
    public ?float $mtime;

    /**
     * @var ?string $amount Position amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $amountInMoney Position amount in [money](/glossary#money)
     */
    #[JsonProperty('amount_in_money')]
    public ?string $amountInMoney;

    /**
     * @var ?string $basePrice Base price of position
     */
    #[JsonProperty('base_price')]
    public ?string $basePrice;

    /**
     * @var ?string $pnl Unrealized PnL in **money**
     */
    #[JsonProperty('pnl')]
    public ?string $pnl;

    /**
     * @var ?string $liqPrice Liquidation price according to current state of position
     */
    #[JsonProperty('liq_price')]
    public ?string $liqPrice;

    /**
     * @var ?value-of<PositionsUpdateParamsRecordsItemLiqStage> $liqStage Liquidation state. Possible values: null, margin_call
     */
    #[JsonProperty('liq_stage')]
    public ?string $liqStage;

    /**
     * @var ?string $unrealizedFunding Funding to be paid on the next position stage change (order, liquidation, etc)
     */
    #[JsonProperty('unrealized_funding')]
    public ?string $unrealizedFunding;

    /**
     * @var ?string $funding Funding already disbursed
     */
    #[JsonProperty('funding')]
    public ?string $funding;

    /**
     * @var ?string $margin Own funds amount in open position in **money**
     */
    #[JsonProperty('margin')]
    public ?string $margin;

    /**
     * @var ?string $freeMargin Free funds for trading
     */
    #[JsonProperty('free_margin')]
    public ?string $freeMargin;

    /**
     * @var ?string $realizedPnl Realized PnL in **money**
     */
    #[JsonProperty('realized_pnl')]
    public ?string $realizedPnl;

    /**
     * @var ?value-of<PositionsUpdateParamsRecordsItemPositionSide> $positionSide Position side - LONG or SHORT or BOTH
     */
    #[JsonProperty('position_side')]
    public ?string $positionSide;

    /**
     * @param array{
     *   id?: ?int,
     *   market?: ?string,
     *   ctime?: ?float,
     *   mtime?: ?float,
     *   amount?: ?string,
     *   amountInMoney?: ?string,
     *   basePrice?: ?string,
     *   pnl?: ?string,
     *   liqPrice?: ?string,
     *   liqStage?: ?value-of<PositionsUpdateParamsRecordsItemLiqStage>,
     *   unrealizedFunding?: ?string,
     *   funding?: ?string,
     *   margin?: ?string,
     *   freeMargin?: ?string,
     *   realizedPnl?: ?string,
     *   positionSide?: ?value-of<PositionsUpdateParamsRecordsItemPositionSide>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->ctime = $values['ctime'] ?? null;
        $this->mtime = $values['mtime'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->amountInMoney = $values['amountInMoney'] ?? null;
        $this->basePrice = $values['basePrice'] ?? null;
        $this->pnl = $values['pnl'] ?? null;
        $this->liqPrice = $values['liqPrice'] ?? null;
        $this->liqStage = $values['liqStage'] ?? null;
        $this->unrealizedFunding = $values['unrealizedFunding'] ?? null;
        $this->funding = $values['funding'] ?? null;
        $this->margin = $values['margin'] ?? null;
        $this->freeMargin = $values['freeMargin'] ?? null;
        $this->realizedPnl = $values['realizedPnl'] ?? null;
        $this->positionSide = $values['positionSide'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
