<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class SubAccountApiKeyList extends JsonSerializableType
{
    /**
     * @var ?string $subAccountId
     */
    #[JsonProperty('subAccountId')]
    public ?string $subAccountId;

    /**
     * @var ?string $id
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $title
     */
    #[JsonProperty('title')]
    public ?string $title;

    /**
     * @var ?bool $isEnabled
     */
    #[JsonProperty('isEnabled')]
    public ?bool $isEnabled;

    /**
     * @var ?string $apiKey
     */
    #[JsonProperty('apiKey')]
    public ?string $apiKey;

    /**
     * @var ?string $apiSecret Empty for security (only shown during creation)
     */
    #[JsonProperty('apiSecret')]
    public ?string $apiSecret;

    /**
     * @var ?string $type
     */
    #[JsonProperty('type')]
    public ?string $type;

    /**
     * @var ?int $lastActivity
     */
    #[JsonProperty('lastActivity')]
    public ?int $lastActivity;

    /**
     * @var ?bool $restrictAccess
     */
    #[JsonProperty('restrictAccess')]
    public ?bool $restrictAccess;

    /**
     * @var ?array<SubAccountApiKeyListAccessEndpointsItem> $accessEndpoints
     */
    #[JsonProperty('accessEndpoints'), ArrayType([SubAccountApiKeyListAccessEndpointsItem::class])]
    public ?array $accessEndpoints;

    /**
     * @param array{
     *   subAccountId?: ?string,
     *   id?: ?string,
     *   title?: ?string,
     *   isEnabled?: ?bool,
     *   apiKey?: ?string,
     *   apiSecret?: ?string,
     *   type?: ?string,
     *   lastActivity?: ?int,
     *   restrictAccess?: ?bool,
     *   accessEndpoints?: ?array<SubAccountApiKeyListAccessEndpointsItem>,
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
