<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class MarketStatistics extends JsonSerializableType
{
    /**
     * @var int $period Period in seconds
     */
    #[JsonProperty('period')]
    public int $period;

    /**
     * @var string $last Last price
     */
    #[JsonProperty('last')]
    public string $last;

    /**
     * @var string $open Open price at 'now - period' time
     */
    #[JsonProperty('open')]
    public string $open;

    /**
     * @var string $close Closing price for the period
     */
    #[JsonProperty('close')]
    public string $close;

    /**
     * @var string $high Highest price in the period
     */
    #[JsonProperty('high')]
    public string $high;

    /**
     * @var string $low Lowest price in the period
     */
    #[JsonProperty('low')]
    public string $low;

    /**
     * @var string $volume Volume in [stock](/glossary#stock) currency
     */
    #[JsonProperty('volume')]
    public string $volume;

    /**
     * @var string $deal Volume in [money](/glossary#money) currency
     */
    #[JsonProperty('deal')]
    public string $deal;

    /**
     * @param array{
     *   period: int,
     *   last: string,
     *   open: string,
     *   close: string,
     *   high: string,
     *   low: string,
     *   volume: string,
     *   deal: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->period = $values['period'];
        $this->last = $values['last'];
        $this->open = $values['open'];
        $this->close = $values['close'];
        $this->high = $values['high'];
        $this->low = $values['low'];
        $this->volume = $values['volume'];
        $this->deal = $values['deal'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
