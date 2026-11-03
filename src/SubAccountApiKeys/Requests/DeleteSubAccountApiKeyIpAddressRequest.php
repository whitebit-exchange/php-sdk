<?php

namespace Whitebit\SubAccountApiKeys\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class DeleteSubAccountApiKeyIpAddressRequest extends JsonSerializableType
{
    /**
     * @var string $apiKeyId ID of the API key to remove IP address from
     */
    #[JsonProperty('apiKeyId')]
    public string $apiKeyId;

    /**
     * @var string $ip IP address to remove from allowed list
     */
    #[JsonProperty('ip')]
    public string $ip;

    /**
     * @param array{
     *   apiKeyId: string,
     *   ip: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->apiKeyId = $values['apiKeyId'];
        $this->ip = $values['ip'];
    }
}
