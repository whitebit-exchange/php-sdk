<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class ListMiningWatcherLinksRequest extends JsonSerializableType
{
    /**
     * @var string $account Mining pool account name
     */
    #[JsonProperty('account')]
    public string $account;

    /**
     * @param array{
     *   account: string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->account = $values['account'];
    }
}
