<?php

namespace Whitebit\Deposit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetFiatDepositUrlResponse extends JsonSerializableType
{
    /**
     * @var ?string $url Address for deposit
     */
    #[JsonProperty('url')]
    public ?string $url;

    /**
     * @param array{
     *   url?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->url = $values['url'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
