<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class MarketTodayStatistics extends JsonSerializableType
{
    /**
     * @var string $last Last price
     */
    #[JsonProperty('last')]
    public string $last;

    /**
     * @var string $open Open price at today's start (UTC midnight)
     */
    #[JsonProperty('open')]
    public string $open;

    /**
     * @var string $high Highest price today
     */
    #[JsonProperty('high')]
    public string $high;

    /**
     * @var string $low Lowest price today
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
     *   last: string,
     *   open: string,
     *   high: string,
     *   low: string,
     *   volume: string,
     *   deal: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->last = $values['last'];
        $this->open = $values['open'];
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
