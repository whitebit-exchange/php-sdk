<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class SubAccount extends JsonSerializableType
{
    /**
     * @var ?string $id Sub-account identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?string $alias Sub-account alias/name
     */
    #[JsonProperty('alias')]
    public ?string $alias;

    /**
     * @var ?string $userId User identifier associated with account
     */
    #[JsonProperty('userId')]
    public ?string $userId;

    /**
     * @var ?string $email Sub-account email (masked)
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * @var ?string $status Sub-account status
     */
    #[JsonProperty('status')]
    public ?string $status;

    /**
     * @var ?string $color Sub-account color
     */
    #[JsonProperty('color')]
    public ?string $color;

    /**
     * @var ?SubAccountKyc $kyc KYC information
     */
    #[JsonProperty('kyc')]
    public ?SubAccountKyc $kyc;

    /**
     * @var ?SubAccountPermissions $permissions Sub-account permissions
     */
    #[JsonProperty('permissions')]
    public ?SubAccountPermissions $permissions;

    /**
     * @param array{
     *   id?: ?string,
     *   alias?: ?string,
     *   userId?: ?string,
     *   email?: ?string,
     *   status?: ?string,
     *   color?: ?string,
     *   kyc?: ?SubAccountKyc,
     *   permissions?: ?SubAccountPermissions,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->alias = $values['alias'] ?? null;
        $this->userId = $values['userId'] ?? null;
        $this->email = $values['email'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->color = $values['color'] ?? null;
        $this->kyc = $values['kyc'] ?? null;
        $this->permissions = $values['permissions'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
