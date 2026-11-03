<?php

namespace Whitebit\SubAccountApiKeys\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ListSubAccountApiKeyIpAddressesRequest extends JsonSerializableType
{
    /**
     * @var string $apiKeyId ID of the API key to list IP addresses for
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
