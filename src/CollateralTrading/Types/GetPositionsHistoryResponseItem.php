<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetPositionsHistoryResponseItem extends JsonSerializableType
{
    /**
     * @var ?int $positionId Position identifier
     */
    #[JsonProperty('positionId')]
    public ?int $positionId;

    /**
     * @var ?string $market Position market
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?float $openDate Date of position opening in Unix timestamp format
     */
    #[JsonProperty('openDate')]
    public ?float $openDate;

    /**
     * @var ?float $modifyDate Date of position modification (current event) in Unix timestamp format
     */
    #[JsonProperty('modifyDate')]
    public ?float $modifyDate;

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
     * @var ?string $realizedFunding Funding fee for whole position lifetime till current state
     */
    #[JsonProperty('realizedFunding')]
    public ?string $realizedFunding;

    /**
     * @var ?string $liquidationPrice Liquidation price according to current state of position
     */
    #[JsonProperty('liquidationPrice')]
    public ?string $liquidationPrice;

    /**
     * @var ?value-of<GetPositionsHistoryResponseItemLiquidationState> $liquidationState State of liquidation
     */
    #[JsonProperty('liquidationState')]
    public ?string $liquidationState;

    /**
     * @var ?GetPositionsHistoryResponseItemOrderDetail $orderDetail Details of order which changes position
     */
    #[JsonProperty('orderDetail')]
    public ?GetPositionsHistoryResponseItemOrderDetail $orderDetail;

    /**
     * @var ?value-of<GetPositionsHistoryResponseItemSide> $side Position direction. `BOTH` indicates a one-way mode position; `LONG` or `SHORT` indicates a hedge mode position. See [position side](/glossary#position-side).
     */
    #[JsonProperty('side')]
    public ?string $side;

    /**
     * @var ?bool $isHedge Indicates whether [hedge mode](/glossary#hedge-mode) was active when the position was opened. Hedge-mode toggling requires zero open positions, so the value also reflects the account mode at every event in the position's lifetime.
     */
    #[JsonProperty('isHedge')]
    public ?bool $isHedge;

    /**
     * @param array{
     *   positionId?: ?int,
     *   market?: ?string,
     *   openDate?: ?float,
     *   modifyDate?: ?float,
     *   amount?: ?string,
     *   basePrice?: ?string,
     *   realizedFunding?: ?string,
     *   liquidationPrice?: ?string,
     *   liquidationState?: ?value-of<GetPositionsHistoryResponseItemLiquidationState>,
     *   orderDetail?: ?GetPositionsHistoryResponseItemOrderDetail,
     *   side?: ?value-of<GetPositionsHistoryResponseItemSide>,
     *   isHedge?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->positionId = $values['positionId'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->openDate = $values['openDate'] ?? null;
        $this->modifyDate = $values['modifyDate'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->basePrice = $values['basePrice'] ?? null;
        $this->realizedFunding = $values['realizedFunding'] ?? null;
        $this->liquidationPrice = $values['liquidationPrice'] ?? null;
        $this->liquidationState = $values['liquidationState'] ?? null;
        $this->orderDetail = $values['orderDetail'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->isHedge = $values['isHedge'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
