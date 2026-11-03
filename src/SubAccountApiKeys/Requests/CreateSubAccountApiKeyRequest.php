<?php

namespace Whitebit\SubAccountApiKeys\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateSubAccountApiKeyRequest extends JsonSerializableType
{
    /**
     * @var int $type Type of API key (1 - info and trading; 2 - info, trading, deposits, withdraws)
     */
    #[JsonProperty('type')]
    public int $type;

    /**
     * @var string $subAccountId ID of the sub-account to create the API key for
     */
    #[JsonProperty('subAccountId')]
    public string $subAccountId;

    /**
     * @var string $title Custom title/name for the API key
     */
    #[JsonProperty('title')]
    public string $title;

    /**
     * @param array{
     *   type: int,
     *   subAccountId: string,
     *   title: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->subAccountId = $values['subAccountId'];
        $this->title = $values['title'];
    }
}
