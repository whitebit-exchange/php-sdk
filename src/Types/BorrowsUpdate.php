<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class BorrowsUpdate extends JsonSerializableType
{
    /**
     * @var mixed $id Update events have null id
     */
    #[JsonProperty('id')]
    public mixed $id;

    /**
     * @var value-of<BorrowsUpdateMethod> $method Method name. Fixed value: `borrowsMargin_update`.
     */
    #[JsonProperty('method')]
    public string $method;

    /**
     * @var BorrowsUpdateParams $params
     */
    #[JsonProperty('params')]
    public BorrowsUpdateParams $params;

    /**
     * @param array{
     *   method: value-of<BorrowsUpdateMethod>,
     *   params: BorrowsUpdateParams,
     *   id?: mixed,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'] ?? null;
        $this->method = $values['method'];
        $this->params = $values['params'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
