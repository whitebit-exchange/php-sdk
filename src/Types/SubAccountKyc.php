<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * KYC information
 */
class SubAccountKyc extends JsonSerializableType
{
    /**
     * @var ?bool $shareKyc Whether KYC is shared with main account
     */
    #[JsonProperty('shareKyc')]
    public ?bool $shareKyc;

    /**
     * @var ?string $kycStatus KYC status
     */
    #[JsonProperty('kycStatus')]
    public ?string $kycStatus;

    /**
     * @param array{
     *   shareKyc?: ?bool,
     *   kycStatus?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->shareKyc = $values['shareKyc'] ?? null;
        $this->kycStatus = $values['kycStatus'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
