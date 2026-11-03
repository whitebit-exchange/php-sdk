<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Traits\BaseRequest;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class PingRequest extends JsonSerializableType
{
    use BaseRequest;

    /**
     * @var ?value-of<PingRequestMethod> $method Method name. Fixed value: `ping`.
     */
    #[JsonProperty('method')]
    public ?string $method;

    /**
     * @var ?array<mixed> $params
     */
    #[JsonProperty('params'), ArrayType(['mixed'])]
    public ?array $params;

    /**
     * @param array{
     *   id: int,
     *   method?: ?value-of<PingRequestMethod>,
     *   params?: ?array<mixed>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->method = $values['method'] ?? null;
        $this->params = $values['params'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
