<?php

namespace Whitebit\MiningPool\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateMiningAccountRequest extends JsonSerializableType
{
    /**
     * @var string $name Mining pool account name. Must be unique. Alphanumeric characters and underscores allowed.
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var ?string $referralCode Optional referral code for account creation
     */
    #[JsonProperty('referralCode')]
    public ?string $referralCode;

    /**
     * @var string $request Request signature
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce Unique request identifier
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   name: string,
     *   request: string,
     *   nonce: int,
     *   referralCode?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->name = $values['name'];
        $this->referralCode = $values['referralCode'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
