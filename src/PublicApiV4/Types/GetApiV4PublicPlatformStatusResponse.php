<?php

namespace Whitebit\PublicApiV4\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetApiV4PublicPlatformStatusResponse extends JsonSerializableType
{
    /**
     * @var value-of<GetApiV4PublicPlatformStatusResponseStatus> $status Platform operational state. `"system operational"` indicates all services are available. `"system maintenance"` indicates the platform is undergoing planned maintenance.
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   status: value-of<GetApiV4PublicPlatformStatusResponseStatus>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->status = $values['status'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
