<?php

namespace Whitebit\SubAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SubAccount\Types\CreateSubAccountRequestPermissions;

class CreateSubAccountRequest extends JsonSerializableType
{
    /**
     * @var string $alias Name for sub-account
     */
    #[JsonProperty('alias')]
    public string $alias;

    /**
     * @var ?string $email Sub-account email (required when shareKyc is false)
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * @var ?bool $shareKyc If KYC shared with main account
     */
    #[JsonProperty('shareKyc')]
    public ?bool $shareKyc;

    /**
     * @var CreateSubAccountRequestPermissions $permissions
     */
    #[JsonProperty('permissions')]
    public CreateSubAccountRequestPermissions $permissions;

    /**
     * @param array{
     *   alias: string,
     *   permissions: CreateSubAccountRequestPermissions,
     *   email?: ?string,
     *   shareKyc?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->alias = $values['alias'];
        $this->email = $values['email'] ?? null;
        $this->shareKyc = $values['shareKyc'] ?? null;
        $this->permissions = $values['permissions'];
    }
}
