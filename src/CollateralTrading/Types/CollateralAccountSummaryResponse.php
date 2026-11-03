<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CollateralAccountSummaryResponse extends JsonSerializableType
{
    /**
     * @var ?string $equity Total equity value of the collateral account
     */
    #[JsonProperty('equity')]
    public ?string $equity;

    /**
     * @var ?string $margin Total margin used
     */
    #[JsonProperty('margin')]
    public ?string $margin;

    /**
     * @var ?string $freeMargin Available margin for trading
     */
    #[JsonProperty('freeMargin')]
    public ?string $freeMargin;

    /**
     * @var ?string $unrealizedFunding Unrealized funding payments
     */
    #[JsonProperty('unrealizedFunding')]
    public ?string $unrealizedFunding;

    /**
     * @var ?string $pnl Unrealized profit and loss
     */
    #[JsonProperty('pnl')]
    public ?string $pnl;

    /**
     * @var ?int $leverage Current leverage level
     */
    #[JsonProperty('leverage')]
    public ?int $leverage;

    /**
     * @var ?string $marginFraction Margin fraction ratio (margin / equity)
     */
    #[JsonProperty('marginFraction')]
    public ?string $marginFraction;

    /**
     * @param array{
     *   equity?: ?string,
     *   margin?: ?string,
     *   freeMargin?: ?string,
     *   unrealizedFunding?: ?string,
     *   pnl?: ?string,
     *   leverage?: ?int,
     *   marginFraction?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->equity = $values['equity'] ?? null;
        $this->margin = $values['margin'] ?? null;
        $this->freeMargin = $values['freeMargin'] ?? null;
        $this->unrealizedFunding = $values['unrealizedFunding'] ?? null;
        $this->pnl = $values['pnl'] ?? null;
        $this->leverage = $values['leverage'] ?? null;
        $this->marginFraction = $values['marginFraction'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
