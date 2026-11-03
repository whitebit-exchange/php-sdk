<?php

namespace Whitebit\CryptoLendingFlex\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class WithdrawFromFlexInvestmentResponse extends JsonSerializableType
{
    /**
     * @var ?WithdrawFromFlexInvestmentResponseData $data
     */
    #[JsonProperty('data')]
    public ?WithdrawFromFlexInvestmentResponseData $data;

    /**
     * @param array{
     *   data?: ?WithdrawFromFlexInvestmentResponseData,
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
