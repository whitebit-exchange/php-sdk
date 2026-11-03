<?php

namespace Whitebit\CryptoLendingFlex\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CloseFlexInvestmentResponseData extends JsonSerializableType
{
    /**
     * @var ?string $transactionId Transaction ID for the closure
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
