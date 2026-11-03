<?php

namespace Whitebit\CryptoLendingFixed\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CloseFixedInvestmentRequest extends JsonSerializableType
{
    /**
     * @var string $id Investment identifier
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var string $request Request signature
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   id: string,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
