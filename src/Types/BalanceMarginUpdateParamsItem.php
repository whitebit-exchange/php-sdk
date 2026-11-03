<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Margin balance update object (uses abbreviated keys)
 */
class BalanceMarginUpdateParamsItem extends JsonSerializableType
{
    /**
     * @var ?string $a Asset [ticker](/glossary#ticker)
     */
    #[JsonProperty('a')]
    public ?string $a;

    /**
     * @var ?string $b Total amount on [collateral balance](/glossary#balance-collateral)
     */
    #[JsonProperty('B')]
    public ?string $b;

    /**
     * @var ?string $b Borrowed amount
     */
    #[JsonProperty('b')]
    public ?string $b;

    /**
     * @var ?string $av Available amount to transfer from collateral balance without borrowing
     */
    #[JsonProperty('av')]
    public ?string $av;

    /**
     * @var ?string $ab Available amount to transfer from collateral balance with borrowing
     */
    #[JsonProperty('ab')]
    public ?string $ab;

    /**
     * @param array{
     *   a?: ?string,
     *   b?: ?string,
     *   b?: ?string,
     *   av?: ?string,
     *   ab?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->a = $values['a'] ?? null;
        $this->b = $values['b'] ?? null;
        $this->b = $values['b'] ?? null;
        $this->av = $values['av'] ?? null;
        $this->ab = $values['ab'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
