<?php

namespace Whitebit\SubAccountApiKeys\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class EditSubAccountApiKeyRequestUrlsItem extends JsonSerializableType
{
    /**
     * @var ?string $url
     */
    #[JsonProperty('url')]
    public ?string $url;

    /**
     * @var ?bool $enable
     */
    #[JsonProperty('enable')]
    public ?bool $enable;

    /**
     * @param array{
     *   url?: ?string,
     *   enable?: ?bool,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->url = $values['url'] ?? null;
        $this->enable = $values['enable'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
