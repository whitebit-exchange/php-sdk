<?php

namespace Whitebit\Jwt\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetWebSocketTokenResponse extends JsonSerializableType
{
    /**
     * @var ?string $websocketToken WebSocket authentication token
     */
    #[JsonProperty('websocket_token')]
    public ?string $websocketToken;

    /**
     * @param array{
     *   websocketToken?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->websocketToken = $values['websocketToken'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
