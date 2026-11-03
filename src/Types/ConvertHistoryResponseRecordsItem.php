<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class ConvertHistoryResponseRecordsItem extends JsonSerializableType
{
    /**
     * @var ?string $id Convert record ID
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?int $date Conversion timestamp
     */
    #[JsonProperty('date')]
    public ?int $date;

    /**
     * @var ?string $give Amount given
     */
    #[JsonProperty('give')]
    public ?string $give;

    /**
     * @var ?string $receive Amount received
     */
    #[JsonProperty('receive')]
    public ?string $receive;

    /**
     * @var ?string $rate Conversion rate
     */
    #[JsonProperty('rate')]
    public ?string $rate;

    /**
     * @var ?array<ConvertHistoryResponseRecordsItemPathItem> $path
     */
    #[JsonProperty('path'), ArrayType([ConvertHistoryResponseRecordsItemPathItem::class])]
    public ?array $path;

    /**
     * @param array{
     *   id?: ?string,
     *   date?: ?int,
     *   give?: ?string,
     *   receive?: ?string,
     *   rate?: ?string,
     *   path?: ?array<ConvertHistoryResponseRecordsItemPathItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->date = $values['date'] ?? null;
        $this->give = $values['give'] ?? null;
        $this->receive = $values['receive'] ?? null;
        $this->rate = $values['rate'] ?? null;
        $this->path = $values['path'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
