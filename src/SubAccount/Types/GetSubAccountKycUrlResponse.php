<?php

namespace Whitebit\SubAccount\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetSubAccountKycUrlResponse extends JsonSerializableType
{
    /**
     * @var string $url Temporary KYC verification URL
     */
    #[JsonProperty('url')]
    public string $url;

    /**
     * @var int $expiresIn Time in seconds until the link expires
     */
    #[JsonProperty('expiresIn')]
    public int $expiresIn;

    /**
     * @param array{
     *   url: string,
     *   expiresIn: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->url = $values['url'];
        $this->expiresIn = $values['expiresIn'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
