<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ConvertHistoryResponseRecordsItemPathItem extends JsonSerializableType
{
    /**
     * @var ?string $from
     */
    #[JsonProperty('from')]
    public ?string $from;

    /**
     * @var ?string $to
     */
    #[JsonProperty('to')]
    public ?string $to;

    /**
     * @var ?string $rate
     */
    #[JsonProperty('rate')]
    public ?string $rate;

    /**
     * @param array{
     *   from?: ?string,
     *   to?: ?string,
     *   rate?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->from = $values['from'] ?? null;
        $this->to = $values['to'] ?? null;
        $this->rate = $values['rate'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
