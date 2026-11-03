<?php

namespace Whitebit\Withdraw\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateExpressWithdrawTokenResponse extends JsonSerializableType
{
    /**
     * @var ?string $url URL to present to the paying user (redirect, deep link, or QR code). The value is the WhiteBIT-hosted web confirmation page by default, or a mobile deep link when one is configured for the partner at onboarding; in both cases the unique token travels in the `token` query parameter. Treat the value as opaque.
     */
    #[JsonProperty('url')]
    public ?string $url;

    /**
     * @var ?string $expireAt Absolute token expiry timestamp in `YYYY-MM-DD HH:MM:SS` format (UTC). The authoritative expiry: each token expires 90 seconds after creation.
     */
    #[JsonProperty('expireAt')]
    public ?string $expireAt;

    /**
     * @param array{
     *   url?: ?string,
     *   expireAt?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->url = $values['url'] ?? null;
        $this->expireAt = $values['expireAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
