<?php

namespace Whitebit\SpotTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class SetKillSwitchResponseCancellationTime extends JsonSerializableType
{
    /**
     * @var ?string $market Trading pair the timer applies to.
     */
    #[JsonProperty('market')]
    public ?string $market;

    /**
     * @var ?int $startTime Unix timestamp (seconds) when the timer was created or last reset.
     */
    #[JsonProperty('startTime')]
    public ?int $startTime;

    /**
     * @var ?int $cancellationTime Unix timestamp (seconds) when the kill-switch will cancel orders. Equals `startTime + timeout`.
     */
    #[JsonProperty('cancellationTime')]
    public ?int $cancellationTime;

    /**
     * @var ?array<value-of<SetKillSwitchResponseCancellationTimeTypesItem>> $types Order types targeted by the kill-switch. Possible values: `spot`, `margin`, `futures`. Returns `null` when the timer was created without `types` (the kill-switch then targets all order types).
     */
    #[JsonProperty('types'), ArrayType(['string'])]
    public ?array $types;

    /**
     * @param array{
     *   market?: ?string,
     *   startTime?: ?int,
     *   cancellationTime?: ?int,
     *   types?: ?array<value-of<SetKillSwitchResponseCancellationTimeTypesItem>>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->market = $values['market'] ?? null;
        $this->startTime = $values['startTime'] ?? null;
        $this->cancellationTime = $values['cancellationTime'] ?? null;
        $this->types = $values['types'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
