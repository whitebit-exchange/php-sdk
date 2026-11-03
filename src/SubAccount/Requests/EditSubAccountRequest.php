<?php

namespace Whitebit\SubAccount\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SubAccount\Types\EditSubAccountRequestPermissions;

class EditSubAccountRequest extends JsonSerializableType
{
    /**
     * @var string $id Sub-account id
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var string $alias Name for sub-account
     */
    #[JsonProperty('alias')]
    public string $alias;

    /**
     * @var EditSubAccountRequestPermissions $permissions
     */
    #[JsonProperty('permissions')]
    public EditSubAccountRequestPermissions $permissions;

    /**
     * @param array{
     *   id: string,
     *   alias: string,
     *   permissions: EditSubAccountRequestPermissions,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->alias = $values['alias'];
        $this->permissions = $values['permissions'];
    }
}
