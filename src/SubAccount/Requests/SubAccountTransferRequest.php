<?php

namespace Whitebit\SubAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SubAccount\Types\SubAccountTransferRequestDirection;

class SubAccountTransferRequest extends JsonSerializableType
{
    /**
     * @var string $id Sub-account id
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var value-of<SubAccountTransferRequestDirection> $direction Transfer direction
     */
    #[JsonProperty('direction')]
    public string $direction;

    /**
     * @var string $amount Transfer amount (min 0.00000001)
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var string $ticker Currency's [ticker](/glossary#ticker)
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @param array{
     *   id: string,
     *   direction: value-of<SubAccountTransferRequestDirection>,
     *   amount: string,
     *   ticker: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->direction = $values['direction'];
        $this->amount = $values['amount'];
        $this->ticker = $values['ticker'];
    }
}
