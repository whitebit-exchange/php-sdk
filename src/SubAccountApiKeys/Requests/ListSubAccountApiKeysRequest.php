<?php

namespace Whitebit\SubAccountApiKeys\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ListSubAccountApiKeysRequest extends JsonSerializableType
{
    /**
     * @var ?string $subAccountId ID of the sub-account to list API keys for
     */
    #[JsonProperty('subAccountId')]
    public ?string $subAccountId;

    /**
     * @var ?int $limit
     */
    #[JsonProperty('limit')]
    public ?int $limit;

    /**
     * @var ?int $offset
     */
    #[JsonProperty('offset')]
    public ?int $offset;

    /**
     * @param array{
     *   subAccountId?: ?string,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->subAccountId = $values['subAccountId'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
    }
}
