<?php

namespace Whitebit\CryptoLendingFlex\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CloseFlexInvestmentResponse extends JsonSerializableType
{
    /**
     * @var ?CloseFlexInvestmentResponseData $data
     */
    #[JsonProperty('data')]
    public ?CloseFlexInvestmentResponseData $data;

    /**
     * @param array{
     *   data?: ?CloseFlexInvestmentResponseData,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->data = $values['data'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
