<?php

namespace Whitebit\SpotTrading\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\SpotTrading\Types\SetKillSwitchRequestTypesItem;
use Whitebit\Core\Types\ArrayType;

class SetKillSwitchRequest extends JsonSerializableType
{
    /**
     * @var string $market Available [market](/glossary#market). Example: BTC_USDT
     */
    #[JsonProperty('market')]
    public string $market;

    /**
     * @var ?string $timeout Timer value in seconds ('5'-'600'), or `null` to delete the existing timer. The key must always be present — omitting it fails validation.
     */
    #[JsonProperty('timeout')]
    public ?string $timeout;

    /**
     * @var ?array<value-of<SetKillSwitchRequestTypesItem>> $types Order types to target. Valid values: "spot" — standard spot orders. "margin" — marginal orders placed on spot markets. Note: the "margin" value is not the same as the collateral account balance; "collateral" in other endpoints refers to the funding account, whereas "margin" here refers specifically to the order type. "futures" — marginal orders placed on futures markets (e.g., BTC_PERP). If omitted, the API targets all order types.
     */
    #[JsonProperty('types'), ArrayType(['string'])]
    public ?array $types;

    /**
     * @var ?string $request
     */
    #[JsonProperty('request')]
    public ?string $request;

    /**
     * @var ?int $nonce
     */
    #[JsonProperty('nonce')]
    public ?int $nonce;

    /**
     * @param array{
     *   market: string,
     *   timeout?: ?string,
     *   types?: ?array<value-of<SetKillSwitchRequestTypesItem>>,
     *   request?: ?string,
     *   nonce?: ?int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->market = $values['market'];
        $this->timeout = $values['timeout'] ?? null;
        $this->types = $values['types'] ?? null;
        $this->request = $values['request'] ?? null;
        $this->nonce = $values['nonce'] ?? null;
    }
}
