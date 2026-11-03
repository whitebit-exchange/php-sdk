<?php

namespace Whitebit\Codes\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ApplyCodeResponse extends JsonSerializableType
{
    /**
     * @var ?string $message
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @var ?string $ticker
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?string $amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $externalId
     */
    #[JsonProperty('external_id')]
    public ?string $externalId;

    /**
     * @param array{
     *   message?: ?string,
     *   ticker?: ?string,
     *   amount?: ?string,
     *   externalId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->message = $values['message'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->externalId = $values['externalId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
