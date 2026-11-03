<?php

namespace Whitebit\Deposit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Deposit\Types\CreateNewAddressRequestType;

class CreateNewAddressRequest extends JsonSerializableType
{
    /**
     * @var string $ticker Currency's ticker.
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @var ?string $network Currency's network (for multinetwork currencies). Example: OMNI or TRC20 or ERC20. For USDT default network is ERC20(ETH).
     */
    #[JsonProperty('network')]
    public ?string $network;

    /**
     * @var ?value-of<CreateNewAddressRequestType> $type Address type, available for specific currencies list (see address types table in endpoint description)
     */
    #[JsonProperty('type')]
    public ?string $type;

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
     *   ticker: string,
     *   request: string,
     *   nonce: int,
     *   network?: ?string,
     *   type?: ?value-of<CreateNewAddressRequestType>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ticker = $values['ticker'];
        $this->network = $values['network'] ?? null;
        $this->type = $values['type'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
