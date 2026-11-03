<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;
use Whitebit\MiningPool\Types\CreateMiningWatcherLinkRequestPermissionsItem;
use Whitebit\MiningPool\Types\CreateMiningWatcherLinkRequestLiveUntil;

class CreateMiningWatcherLinkRequest extends JsonSerializableType
{
    /**
     * @var array<string> $accounts Array of mining account names
     */
    #[JsonProperty('accounts'), ArrayType(['string'])]
    public array $accounts;

    /**
     * @var string $name Link name (alphanumeric and underscores only)
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var array<value-of<CreateMiningWatcherLinkRequestPermissionsItem>> $permissions Array of permissions
     */
    #[JsonProperty('permissions'), ArrayType(['string'])]
    public array $permissions;

    /**
     * @var value-of<CreateMiningWatcherLinkRequestLiveUntil> $liveUntil Expiration period
     */
    #[JsonProperty('liveUntil')]
    public string $liveUntil;

    /**
     * @param array{
     *   accounts: array<string>,
     *   name: string,
     *   permissions: array<value-of<CreateMiningWatcherLinkRequestPermissionsItem>>,
     *   liveUntil: value-of<CreateMiningWatcherLinkRequestLiveUntil>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->accounts = $values['accounts'];
        $this->name = $values['name'];
        $this->permissions = $values['permissions'];
        $this->liveUntil = $values['liveUntil'];
    }
}
