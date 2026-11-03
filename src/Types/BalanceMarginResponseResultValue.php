<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BalanceMarginResponseResultValue extends JsonSerializableType
{
    /**
     * @var ?string $balance Total amount on [collateral balance](/glossary#balance-collateral)
     */
    #[JsonProperty('balance')]
    public ?string $balance;

    /**
     * @var ?string $borrow Borrowed amount
     */
    #[JsonProperty('borrow')]
    public ?string $borrow;

    /**
     * @var ?string $availableWithoutBorrow Available amount to transfer from collateral balance without borrowing
     */
    #[JsonProperty('available_without_borrow')]
    public ?string $availableWithoutBorrow;

    /**
     * @var ?string $availableWithBorrow Available amount to transfer from collateral balance with borrowing
     */
    #[JsonProperty('available_with_borrow')]
    public ?string $availableWithBorrow;

    /**
     * @param array{
     *   balance?: ?string,
     *   borrow?: ?string,
     *   availableWithoutBorrow?: ?string,
     *   availableWithBorrow?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->balance = $values['balance'] ?? null;
        $this->borrow = $values['borrow'] ?? null;
        $this->availableWithoutBorrow = $values['availableWithoutBorrow'] ?? null;
        $this->availableWithBorrow = $values['availableWithBorrow'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
