<?php

namespace Whitebit\Deposit\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class RefundDepositRequest extends JsonSerializableType
{
    /**
     * @var string $transactionId Transaction UUID of the deposit. Obtain from the [deposit.canceled](/platform/webhook) webhook (`uniqueId` field) or from the deposit/withdraw history in the WhiteBIT interface.
     */
    #[JsonProperty('transactionId')]
    public string $transactionId;

    /**
     * @var string $address Destination wallet address for the refund. The address must support the same network and asset as the original deposit. Cannot be a WhiteBIT address. Does not have to match the original deposit address.
     */
    #[JsonProperty('address')]
    public string $address;

    /**
     * @var string $request Base64-encoded request body. See the [authentication guide](/private/http-auth) for signature generation details.
     */
    #[JsonProperty('request')]
    public string $request;

    /**
     * @var int $nonce A unique identifier for the request. Use a monotonically increasing value such as a Unix timestamp in milliseconds.
     */
    #[JsonProperty('nonce')]
    public int $nonce;

    /**
     * @param array{
     *   transactionId: string,
     *   address: string,
     *   request: string,
     *   nonce: int,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->transactionId = $values['transactionId'];
        $this->address = $values['address'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
