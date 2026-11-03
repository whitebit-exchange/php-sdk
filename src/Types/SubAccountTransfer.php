<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubAccountTransfer extends JsonSerializableType
{
    /**
     * @var ?string $transactionId Transaction identifier. Same value as id. Correlate with the transfer endpoint response using the transaction_id field.
     */
    #[JsonProperty('transaction_id')]
    public ?string $transactionId;

    /**
     * @var ?string $id Transfer identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $direction Transfer direction (main_to_sub or sub_to_main)
     */
    #[JsonProperty('direction')]
    public ?string $direction;

    /**
     * @var ?string $currency Currency transferred
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?string $amount Transfer amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?int $createdAt Transfer creation timestamp
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @param array{
     *   transactionId?: ?string,
     *   id?: ?string,
     *   direction?: ?string,
     *   currency?: ?string,
     *   amount?: ?string,
     *   createdAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->transactionId = $values['transactionId'] ?? null;
        $this->id = $values['id'] ?? null;
        $this->direction = $values['direction'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->createdAt = $values['createdAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
