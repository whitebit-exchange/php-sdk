<?php

namespace Whitebit\Jwt\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class IssueJwtTokenRequest extends JsonSerializableType
{
    /**
     * @var string $request Request signature
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var ?bool $nonceWindow Nonce window setting
     */
    #[JsonProperty('nonceWindow')]
    public ?bool $nonceWindow;

    /**
     * @var int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   request: string,
     *   nonce: int,
     *   nonceWindow?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->request = $values['request'];
        $this->nonceWindow = $values['nonceWindow'] ?? null;
        $this->nonce = $values['nonce'];
    }
}
