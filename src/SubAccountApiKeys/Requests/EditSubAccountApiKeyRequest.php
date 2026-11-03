<?php

namespace Whitebit\SubAccountApiKeys\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SubAccountApiKeys\Types\EditSubAccountApiKeyRequestUrlsItem;
use Whitebit\Core\Types\ArrayType;

class EditSubAccountApiKeyRequest extends JsonSerializableType
{
    /**
     * @var string $apiKeyId ID of the API key to update
     */
    #[JsonProperty('apiKeyId')]
    public string $apiKeyId;

    /**
     * @var string $title New title for the API key
     */
    #[JsonProperty('title')]
    public string $title;

    /**
     * @var array<EditSubAccountApiKeyRequestUrlsItem> $urls Array of URL objects for API key restrictions
     */
    #[JsonProperty('urls'), ArrayType([EditSubAccountApiKeyRequestUrlsItem::class])]
    public array $urls;

    /**
     * @param array{
     *   apiKeyId: string,
     *   title: string,
     *   urls: array<EditSubAccountApiKeyRequestUrlsItem>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->apiKeyId = $values['apiKeyId'];
        $this->title = $values['title'];
        $this->urls = $values['urls'];
    }
}
