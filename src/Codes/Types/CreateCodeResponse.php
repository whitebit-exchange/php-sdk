<?php

namespace Whitebit\Codes\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateCodeResponse extends JsonSerializableType
{
    /**
     * @var ?string $code Generated WhiteBIT code
     */
    #[JsonProperty('code')]
    public ?string $code;

    /**
     * @var ?string $message Success message
     */
    #[JsonProperty('message')]
    public ?string $message;

    /**
     * @var ?string $externalId External identifier
     */
    #[JsonProperty('external_id')]
    public ?string $externalId;

    /**
     * @param array{
     *   code?: ?string,
     *   message?: ?string,
     *   externalId?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->code = $values['code'] ?? null;
        $this->message = $values['message'] ?? null;
        $this->externalId = $values['externalId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
