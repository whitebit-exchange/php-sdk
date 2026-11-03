<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetClosedPositionsPnlResponseItem extends JsonSerializableType
{
    /**
     * @var ?int $positionId Unique identifier of the closed position.
     */
    #[JsonProperty('positionId')]
    public ?int $positionId;

    /**
     * @var ?string $market Market of the position. Format: `BASE_QUOTE`.
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?string $grossPnl Realized profit and loss of the position before funding. Trading fees are already deducted from the value; `totalTradeFee` is informational and must not be subtracted again.
     */
    #[JsonProperty('grossPnl')]
    public ?string $grossPnl;

    /**
     * @var ?string $netPnl Net profit and loss of the position: `grossPnl` minus `totalFunding`.
     */
    #[JsonProperty('netPnl')]
    public ?string $netPnl;

    /**
     * @var ?string $totalTradeFee Sum of trading fees across all fills of the position, both opening and closing. Informational — already reflected in `grossPnl` and `netPnl`.
     */
    #[JsonProperty('totalTradeFee')]
    public ?string $totalTradeFee;

    /**
     * @var ?string $totalFunding Cumulative funding fee over the whole position lifetime.
     */
    #[JsonProperty('totalFunding')]
    public ?string $totalFunding;

    /**
     * @var ?string $avgEntryPrice Volume-weighted average price of the fills that increased the position, trimmed to the market money precision.
     */
    #[JsonProperty('avgEntryPrice')]
    public ?string $avgEntryPrice;

    /**
     * @var ?string $avgExitPrice Volume-weighted average price of the fills that reduced the position, trimmed to the market money precision.
     */
    #[JsonProperty('avgExitPrice')]
    public ?string $avgExitPrice;

    /**
     * @var ?string $closedSize Total closed volume in base currency — the sum of fills that reduced the position.
     */
    #[JsonProperty('closedSize')]
    public ?string $closedSize;

    /**
     * @var ?string $amount Remaining position size. Always returns `"0"` — a closed position holds no size.
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?value-of<GetClosedPositionsPnlResponseItemSide> $side Position direction. Returns `BOTH` for positions opened with hedge mode disabled. See [positionSide](/glossary#position-side).
     */
    #[JsonProperty('side')]
    public ?string $side;

    /**
     * @var ?bool $isHedge Whether the position was opened in [hedge mode](/glossary#hedge-mode).
     */
    #[JsonProperty('isHedge')]
    public ?bool $isHedge;

    /**
     * @var ?int $openDate Position open time as a Unix timestamp in seconds.
     */
    #[JsonProperty('openDate')]
    public ?int $openDate;

    /**
     * @var ?int $closeDate Position close time as a Unix timestamp in seconds. Primary sort key, descending.
     */
    #[JsonProperty('closeDate')]
    public ?int $closeDate;

    /**
     * @param array{
     *   positionId?: ?int,
     *   market?: ?string,
     *   grossPnl?: ?string,
     *   netPnl?: ?string,
     *   totalTradeFee?: ?string,
     *   totalFunding?: ?string,
     *   avgEntryPrice?: ?string,
     *   avgExitPrice?: ?string,
     *   closedSize?: ?string,
     *   amount?: ?string,
     *   side?: ?value-of<GetClosedPositionsPnlResponseItemSide>,
     *   isHedge?: ?bool,
     *   openDate?: ?int,
     *   closeDate?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->positionId = $values['positionId'] ?? null;
        $this->market = $values['market'] ?? null;
        $this->grossPnl = $values['grossPnl'] ?? null;
        $this->netPnl = $values['netPnl'] ?? null;
        $this->totalTradeFee = $values['totalTradeFee'] ?? null;
        $this->totalFunding = $values['totalFunding'] ?? null;
        $this->avgEntryPrice = $values['avgEntryPrice'] ?? null;
        $this->avgExitPrice = $values['avgExitPrice'] ?? null;
        $this->closedSize = $values['closedSize'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->side = $values['side'] ?? null;
        $this->isHedge = $values['isHedge'] ?? null;
        $this->openDate = $values['openDate'] ?? null;
        $this->closeDate = $values['closeDate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
