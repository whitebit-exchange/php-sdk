<?php

namespace Whitebit\CryptoLendingFlex\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateFlexInvestmentResponse extends JsonSerializableType
{
    /**
     * @var ?CreateFlexInvestmentResponseData $data
     */
    #[JsonProperty('data')]
    public ?CreateFlexInvestmentResponseData $data;

    /**
     * @param array{
     *   data?: ?CreateFlexInvestmentResponseData,
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
