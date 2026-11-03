<?php

namespace Whitebit\SubAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class GetSubAccountBalancesRequest extends JsonSerializableType
{
    /**
     * @var string $id Sub-account id
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var ?string $ticker Currency's ticker (if not provided, returns data by all currencies)
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @param array{
     *   id: string,
     *   ticker?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->ticker = $values['ticker'] ?? null;
    }
}
