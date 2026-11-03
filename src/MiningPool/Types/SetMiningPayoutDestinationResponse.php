<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SetMiningPayoutDestinationResponse extends JsonSerializableType
{
    /**
     * @var ?value-of<SetMiningPayoutDestinationResponsePayoutDestination> $payoutDestination
     */
    #[JsonProperty('payoutDestination')]
    public ?string $payoutDestination;

    /**
     * @var ?string $externalAddress
     */
    #[JsonProperty('externalAddress')]
    public ?string $externalAddress;

    /**
     * @param array{
     *   payoutDestination?: ?value-of<SetMiningPayoutDestinationResponsePayoutDestination>,
     *   externalAddress?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->payoutDestination = $values['payoutDestination'] ?? null;
        $this->externalAddress = $values['externalAddress'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
