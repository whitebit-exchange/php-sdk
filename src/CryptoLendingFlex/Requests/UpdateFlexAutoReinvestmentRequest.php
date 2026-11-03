<?php

namespace Whitebit\CryptoLendingFlex\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class UpdateFlexAutoReinvestmentRequest extends JsonSerializableType
{
    /**
     * @var string $plan Plan external ID (UUID).
     */
    #[JsonProperty('plan')]
    public string $plan;

    /**
     * @var ?bool $enabled Enable or disable auto-reinvestment.
     */
    #[JsonProperty('enabled')]
    public ?bool $enabled;

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
     *   plan: string,
     *   request: string,
     *   nonce: int,
     *   enabled?: ?bool,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->plan = $values['plan'];
        $this->enabled = $values['enabled'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
