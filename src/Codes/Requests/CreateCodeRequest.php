<?php

namespace Whitebit\Codes\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateCodeRequest extends JsonSerializableType
{
    /**
     * @var string $ticker Currency's [ticker](/glossary#ticker). Example: BTC
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @var string $amount Amount to transfer. Up to 18 decimal places, value greater than zero and capped at 1e17 (10^17), and not exceeding the [main balance](/glossary#balance-main).
     */
    #[JsonProperty('amount')]
    public string $amount;

    /**
     * @var ?string $passphrase Passphrase for applying [WhiteBIT codes](/glossary#whitebit-codes). Passphrase must contain only latin letters, numbers and symbols (like !@#$%^, no whitespaces). Max: 25 symbols.
     */
    #[JsonProperty('passphrase')]
    public ?string $passphrase;

    /**
     * @var ?string $description Additional text description for [code](/glossary#whitebit-codes). Visible only for creator. Max: 280 symbols.
     */
    #[JsonProperty('description')]
    public ?string $description;

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
     *   amount: string,
     *   request: string,
     *   nonce: int,
     *   passphrase?: ?string,
     *   description?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->ticker = $values['ticker'];
        $this->amount = $values['amount'];
        $this->passphrase = $values['passphrase'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
