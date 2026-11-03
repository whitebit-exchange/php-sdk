<?php

namespace Whitebit\SubAccountApiKeys\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class DeleteSubAccountApiKeyRequest extends JsonSerializableType
{
    /**
     * @var string $apiKeyId ID of the API key to delete
     */
    #[JsonProperty('apiKeyId')]
    public string $apiKeyId;

    /**
     * @param array{
     *   apiKeyId: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->apiKeyId = $values['apiKeyId'];
    }
}
