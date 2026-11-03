<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class TransactionHistory extends JsonSerializableType
{
    /**
     * @var ?string $address Deposit/Withdraw address
     */
    #[JsonProperty('address')]
    public ?string $address;

    /**
     * @var ?string $uniqueId Unique Id of deposit/withdraw. Unique per user.
     */
    #[JsonProperty('unique_id')]
    public ?string $uniqueId;

    /**
     * @var ?int $createdAt Timestamp of deposit/withdraw
     */
    #[JsonProperty('createdAt')]
    public ?int $createdAt;

    /**
     * @var ?string $currency Deposit/Withdraw currency full name
     */
    #[JsonProperty('currency')]
    public ?string $currency;

    /**
     * @var ?string $ticker Deposit/Withdraw currency [ticker](/glossary#ticker)
     */
    #[JsonProperty('ticker')]
    public ?string $ticker;

    /**
     * @var ?int $method Called method: 1 - deposit, 2 - withdraw
     */
    #[JsonProperty('method')]
    public ?int $method;

    /**
     * @var ?string $amount Amount of deposit/withdraw
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $description Deposit/Withdraw description
     */
    #[JsonProperty('description')]
    public ?string $description;

    /**
     * @var ?string $memo [Memo](/glossary#memodestination-tag) for deposit/withdraw
     */
    #[JsonProperty('memo')]
    public ?string $memo;

    /**
     * @var ?string $fee [Fee](/glossary#fee) for deposit/withdraw
     */
    #[JsonProperty('fee')]
    public ?string $fee;

    /**
     * @var ?int $status Transaction status (see endpoint description for status codes)
     */
    #[JsonProperty('status')]
    public ?int $status;

    /**
     * @var ?string $network Network if currency is multinetwork
     */
    #[JsonProperty('network')]
    public ?string $network;

    /**
     * @var ?string $transactionHash Deposit/Withdraw transaction hash. A single hash can map to multiple records (e.g. several outputs to a WhiteBIT address in one on-chain transaction); use `transaction_id` to distinguish them.
     */
    #[JsonProperty('transactionHash')]
    public ?string $transactionHash;

    /**
     * @var ?string $transactionId Transaction UUID. Unique across the whole system and never reused.
     */
    #[JsonProperty('transaction_id')]
    public ?string $transactionId;

    /**
     * @var ?array<string, mixed> $details Additional details for the transaction
     */
    #[JsonProperty('details'), ArrayType(['string' => 'mixed'])]
    public ?array $details;

    /**
     * @var ?TransactionHistoryConfirmations $confirmations Confirmation details for crypto transactions
     */
    #[JsonProperty('confirmations')]
    public ?TransactionHistoryConfirmations $confirmations;

    /**
     * @param array{
     *   address?: ?string,
     *   uniqueId?: ?string,
     *   createdAt?: ?int,
     *   currency?: ?string,
     *   ticker?: ?string,
     *   method?: ?int,
     *   amount?: ?string,
     *   description?: ?string,
     *   memo?: ?string,
     *   fee?: ?string,
     *   status?: ?int,
     *   network?: ?string,
     *   transactionHash?: ?string,
     *   transactionId?: ?string,
     *   details?: ?array<string, mixed>,
     *   confirmations?: ?TransactionHistoryConfirmations,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->address = $values['address'] ?? null;
        $this->uniqueId = $values['uniqueId'] ?? null;
        $this->createdAt = $values['createdAt'] ?? null;
        $this->currency = $values['currency'] ?? null;
        $this->ticker = $values['ticker'] ?? null;
        $this->method = $values['method'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->description = $values['description'] ?? null;
        $this->memo = $values['memo'] ?? null;
        $this->fee = $values['fee'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->network = $values['network'] ?? null;
        $this->transactionHash = $values['transactionHash'] ?? null;
        $this->transactionId = $values['transactionId'] ?? null;
        $this->details = $values['details'] ?? null;
        $this->confirmations = $values['confirmations'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
