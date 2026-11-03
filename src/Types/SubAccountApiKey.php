<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class SubAccountApiKey extends JsonSerializableType
{
    /**
     * @var ?string $subAccountId Sub-account identifier
     */
    #[JsonProperty('subAccountId')]
    public ?string $subAccountId;

    /**
     * @var ?string $id API key identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $title API key title/name
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @var ?bool $isEnabled Whether the API key is enabled
     */
    #[JsonProperty('isEnabled')]
    public ?bool $isEnabled;

    /**
     * @var ?string $apiKey API key
     */
    #[JsonProperty('apiKey')]
    public ?string $apiKey;

    /**
     * @var ?string $apiSecret API secret
     */
    #[JsonProperty('apiSecret')]
    public ?string $apiSecret;

    /**
     * @var ?int $type API key type (1 - info and trading, 2 - info, trading, deposit and withdraw)
     */
    #[JsonProperty('type')]
    public ?int $type;

    /**
     * @var ?int $lastActivity Last activity timestamp
     */
    #[JsonProperty('lastActivity')]
    public ?int $lastActivity;

    /**
     * @var ?bool $restrictAccess Whether access is restricted
     */
    #[JsonProperty('restrictAccess')]
    public ?bool $restrictAccess;

    /**
     * @var ?array<SubAccountApiKeyAccessEndpointsItem> $accessEndpoints List of allowed endpoints
     */
    #[JsonProperty('accessEndpoints'), ArrayType([SubAccountApiKeyAccessEndpointsItem::class])]
    public ?array $accessEndpoints;

    /**
     * @param array{
     *   subAccountId?: ?string,
     *   id?: ?string,
     *   title?: ?string,
     *   isEnabled?: ?bool,
     *   apiKey?: ?string,
     *   apiSecret?: ?string,
     *   type?: ?int,
     *   lastActivity?: ?int,
     *   restrictAccess?: ?bool,
     *   accessEndpoints?: ?array<SubAccountApiKeyAccessEndpointsItem>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->subAccountId = $values['subAccountId'] ?? null;
        $this->id = $values['id'] ?? null;
        $this->title = $values['title'] ?? null;
        $this->isEnabled = $values['isEnabled'] ?? null;
        $this->apiKey = $values['apiKey'] ?? null;
        $this->apiSecret = $values['apiSecret'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->lastActivity = $values['lastActivity'] ?? null;
        $this->restrictAccess = $values['restrictAccess'] ?? null;
        $this->accessEndpoints = $values['accessEndpoints'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
