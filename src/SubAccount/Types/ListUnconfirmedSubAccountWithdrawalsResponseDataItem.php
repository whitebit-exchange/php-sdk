<?php

namespace Whitebit\SubAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ListUnconfirmedSubAccountWithdrawalsResponseDataItem extends JsonSerializableType
{
    /**
     * @var ?string $id Transaction external ID (UUID).
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $subAccountId Sub-account external ID.
     */
    #[JsonProperty('subAccountId')]
    public ?string $subAccountId;

    /**
     * @var ?string $currency Currency ticker.
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?string $amount Withdrawal amount (trailing zeros trimmed).
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?int $createdAt Unix timestamp of transaction creation.
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @param array{
     *   id?: ?string,
     *   subAccountId?: ?string,
     *   currency?: ?string,
     *   amount?: ?string,
     *   createdAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->subAccountId = $values['subAccountId'] ?? null;
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
