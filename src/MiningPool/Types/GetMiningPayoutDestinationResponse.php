<?php

namespace Whitebit\MiningPool\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningPayoutDestinationResponse extends JsonSerializableType
{
    /**
     * @var ?value-of<GetMiningPayoutDestinationResponsePayoutDestination> $payoutDestination Payout destination type
     */
    #[JsonProperty('payoutDestination')]
    public ?string $payoutDestination;

    /**
     * @var ?string $externalAddress External BTC address (null if destination is main_balance)
     */
    #[JsonProperty('externalAddress')]
    public ?string $externalAddress;

    /**
     * @param array{
     *   payoutDestination?: ?value-of<GetMiningPayoutDestinationResponsePayoutDestination>,
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
