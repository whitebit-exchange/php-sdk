<?php

namespace Whitebit\Deposit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class IssueCardTokenRequest extends JsonSerializableType
{
    /**
     * @var string $cardNumber Target card number
     */
    #[JsonProperty('cardNumber')]
    public string $cardNumber;

    /**
     * @param array{
     *   cardNumber: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->cardNumber = $values['cardNumber'];
    }
}
