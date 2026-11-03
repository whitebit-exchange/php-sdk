<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreditLine extends JsonSerializableType
{
    /**
     * @var ?string $asset
     */
    #[JsonProperty('asset')]
    public ?string $asset;

    /**
     * @var ?string $amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $totalFunding
     */
    #[JsonProperty('totalFunding')]
    public ?string $totalFunding;

    /**
     * @var ?string $currentLtv
     */
    #[JsonProperty('currentLtv')]
    public ?string $currentLtv;

    /**
     * @var ?string $initialLtv
     */
    #[JsonProperty('initialLtv')]
    public ?string $initialLtv;

    /**
     * @var ?string $marginCallLtv
     */
    #[JsonProperty('marginCallLtv')]
    public ?string $marginCallLtv;

    /**
     * @var ?string $liquidationLtv
     */
    #[JsonProperty('liquidationLtv')]
    public ?string $liquidationLtv;

    /**
     * @var ?int $createdAt
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @param array{
     *   asset?: ?string,
     *   amount?: ?string,
     *   totalFunding?: ?string,
     *   currentLtv?: ?string,
     *   initialLtv?: ?string,
     *   marginCallLtv?: ?string,
     *   liquidationLtv?: ?string,
     *   createdAt?: ?int,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->asset = $values['asset'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->totalFunding = $values['totalFunding'] ?? null;
        $this->currentLtv = $values['currentLtv'] ?? null;
        $this->initialLtv = $values['initialLtv'] ?? null;
        $this->marginCallLtv = $values['marginCallLtv'] ?? null;
        $this->liquidationLtv = $values['liquidationLtv'] ?? null;
        $this->createdAt = $values['createdAt'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
