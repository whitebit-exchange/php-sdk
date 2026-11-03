<?php

namespace Whitebit\SubAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubAccountTransferResponse extends JsonSerializableType
{
    /**
     * @var ?string $transactionId External identifier of the transaction. Correlate transfer history responses using the `transaction_id` value.
     */
    #[JsonProperty('transaction_id')]
    public ?string $transactionId;

    /**
     * @param array{
     *   transactionId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->transactionId = $values['transactionId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
