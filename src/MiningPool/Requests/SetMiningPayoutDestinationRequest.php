<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\MiningPool\Types\SetMiningPayoutDestinationRequestDestination;

class SetMiningPayoutDestinationRequest extends JsonSerializableType
{
    /**
     * @var string $accountName Mining pool account name
     */
    #[JsonProperty('accountName')]
    public string $accountName;

    /**
     * @var value-of<SetMiningPayoutDestinationRequestDestination> $destination Payout destination type
     */
    #[JsonProperty('destination')]
    public string $destination;

    /**
     * @var ?string $address External BTC address. Required when destination is external_address. Supports all standard Bitcoin address formats.
     */
    #[JsonProperty('address')]
    public ?string $address;

    /**
     * @param array{
     *   accountName: string,
     *   destination: value-of<SetMiningPayoutDestinationRequestDestination>,
     *   address?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountName = $values['accountName'];
        $this->destination = $values['destination'];
        $this->address = $values['address'] ?? null;
    }
}
