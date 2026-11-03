<?php

namespace Whitebit\Codes\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ApplyCodeRequest extends JsonSerializableType
{
    /**
     * @var string $code [Code](/glossary#whitebit-codes) that will be applied.
     */
    #[JsonProperty('code')]
    public string $code;

    /**
     * @var ?string $passphrase Should be provided if the [code](/glossary#whitebit-codes) was created with passphrase. Max: 25 symbols.
     */
    #[JsonProperty('passphrase')]
    public ?string $passphrase;

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
     *   code: string,
     *   request: string,
     *   nonce: int,
     *   passphrase?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->code = $values['code'];
        $this->passphrase = $values['passphrase'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
