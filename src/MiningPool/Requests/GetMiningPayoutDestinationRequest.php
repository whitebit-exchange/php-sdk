<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMiningPayoutDestinationRequest extends JsonSerializableType
{
    /**
     * @var string $accountName Mining pool account name
     */
    #[JsonProperty('accountName')]
    public string $accountName;

    /**
     * @param array{
     *   accountName: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accountName = $values['accountName'];
    }
}
