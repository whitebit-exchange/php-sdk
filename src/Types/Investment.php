<?php

namespace Whitebit\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class Investment extends JsonSerializableType
{
    /**
     * @var ?string $id Investment identifier
     */
    #[JsonProperty('id')]
    public ?string $id;

    /**
     * @var ?FixedPlan $plan Investment plan (similar to Get plans response)
     */
    #[JsonProperty('plan')]
    public ?FixedPlan $plan;

    /**
     * @var ?int $status Investment status (1 - active, 2 - closed)
     */
    #[JsonProperty('status')]
    public ?int $status;

    /**
     * @var ?int $created Timestamp of investment creation
     */
    #[JsonProperty('created')]
    public ?int $created;

    /**
     * @var ?int $updated Timestamp of investment update
     */
    #[JsonProperty('updated')]
    public ?int $updated;

    /**
     * @var ?int $paymentTime Timestamp of the payment time
     */
    #[JsonProperty('paymentTime')]
    public ?int $paymentTime;

    /**
     * @var ?string $amount Investment amount
     */
    #[JsonProperty('amount')]
    public ?string $amount;

    /**
     * @var ?string $interestPaid Interest paid amount
     */
    #[JsonProperty('interestPaid')]
    public ?string $interestPaid;

    /**
     * @param array{
     *   id?: ?string,
     *   plan?: ?FixedPlan,
     *   status?: ?int,
     *   created?: ?int,
     *   updated?: ?int,
     *   paymentTime?: ?int,
     *   amount?: ?string,
     *   interestPaid?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->plan = $values['plan'] ?? null;
        $this->status = $values['status'] ?? null;
        $this->created = $values['created'] ?? null;
        $this->updated = $values['updated'] ?? null;
        $this->paymentTime = $values['paymentTime'] ?? null;
        $this->amount = $values['amount'] ?? null;
        $this->interestPaid = $values['interestPaid'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
