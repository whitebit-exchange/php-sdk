<?php

namespace Whitebit\SubAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SubAccount\Types\GetSubAccountTransferHistoryRequestDirection;

class GetSubAccountTransferHistoryRequest extends JsonSerializableType
{
    /**
     * @var string $id Sub-account id
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var ?value-of<GetSubAccountTransferHistoryRequestDirection> $direction Transfer direction (optional)
     */
    #[JsonProperty('direction')]
    public ?string $direction;

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
     *   id: string,
     *   direction?: ?value-of<GetSubAccountTransferHistoryRequestDirection>,
     *   limit?: ?int,
     *   offset?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->direction = $values['direction'] ?? null;
        $this->limit = $values['limit'] ?? null;
        $this->offset = $values['offset'] ?? null;
    }
}
