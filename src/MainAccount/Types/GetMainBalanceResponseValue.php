<?php

namespace Whitebit\MainAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetMainBalanceResponseValue extends JsonSerializableType
{
    /**
     * @var ?string $mainBalance Main balance volume
     */
    #[JsonProperty('main_balance')]
    public ?string $mainBalance;

    /**
     * @param array{
     *   mainBalance?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->mainBalance = $values['mainBalance'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
