<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CodeInfo extends JsonSerializableType
{
    /**
     * @var ?string $amount Code amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $code WhiteBIT code
     */
    #[JsonProperty('code')]
    public ?string $code;

    /**
     * @var ?int $date Code creation timestamp
     */
    #[JsonProperty('date')]
    public ?int $date;

    /**
     * @var ?string $status Code status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?string $ticker Code [ticker](/glossary#ticker)
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?string $externalId Code external identifier
     */
    #[JsonProperty('external_id')]
    public ?string $externalId;

    /**
     * @param array{
     *   amount?: ?string,
     *   code?: ?string,
     *   date?: ?int,
     *   status?: ?string,
     *   ticker?: ?string,
     *   externalId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->amount = $values['amount'] ?? null;
        $this->code = $values['code'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
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
