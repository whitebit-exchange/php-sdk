<?php

namespace Whitebit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ConvertConfirmRequest extends JsonSerializableType
{
    /**
     * @var string $quoteId Quote ID
     */
    #[JsonProperty('quoteId')]
    public string $quoteId;

    /**
     * @var ?int $nonce Nonce for request
     */
    #[JsonProperty('nonce')]
    public ?int $nonce;

    /**
     * @var ?string $request Request path
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @param array{
     *   quoteId: string,
     *   nonce?: ?int,
     *   request?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->quoteId = $values['quoteId'];
        $this->nonce = $values['nonce'] ?? null;
        $this->request = $values['request'] ?? null;
    }
}
