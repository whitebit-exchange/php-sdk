<?php

namespace Whitebit\Transfer\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Transfer\Types\TransferBetweenBalancesRequestMethod;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Transfer\Types\TransferBetweenBalancesRequestFrom;
use Whitebit\Transfer\Types\TransferBetweenBalancesRequestTo;

class TransferBetweenBalancesRequest extends JsonSerializableType
{
    /**
     * Transfer method.
     *
     * ⚠️ We highly recommend to use **from** and **to** fields, which provides more flexibility. This way will be deprecated in future.
     *
     * Example: **deposit** to transfer from [main](/glossary#balance-main) to [trade](/glossary#balance-spotbalance-trade) / **withdraw** to transfer from [trade](/glossary#balance-spotbalance-trade) balance to [main](/glossary#balance-main). For [collateral balances](/glossary#balance-collateral) use **collateral-deposit** to transfer from main to collateral and **collateral-withdraw** to transfer from collateral to main
     *
     * **Not required** if **from** and **to** are set.
     *
     * @var ?value-of<TransferBetweenBalancesRequestMethod> $method
     */
    #[JsonProperty('method')]
    public ?string $method;

    /**
     * Balance FROM which funds will move to. Acceptable values: [**main**](/glossary#balance-main), [**spot**](/glossary#balance-spotbalance-trade), [**collateral**](/glossary#balance-collateral)
     *
     * **Not required** if **method** is set.
     *
     * @var ?value-of<TransferBetweenBalancesRequestFrom> $from
     */
    #[JsonProperty('from')]
    public ?string $from;

    /**
     * Balance TO which funds will move to. Acceptable values: [**main**](/glossary#balance-main), [**spot**](/glossary#balance-spotbalance-trade), [**collateral**](/glossary#balance-collateral)
     *
     * **Not required** if **method** is set.
     *
     * @var ?value-of<TransferBetweenBalancesRequestTo> $to
     */
    #[JsonProperty('to')]
    public ?string $to;

    /**
     * @var string $ticker Currency's [ticker](/glossary#ticker). Example: BTC
     */
    #[JsonProperty('ticker')]
    public string $ticker;

    /**
     * @var string $amount Amount to transfer. Max [precision](/glossary#precision) = 8, value must be greater than zero and less than or equal to the available balance.
     */
    #[JsonProperty('amount')]
    public string $amount;

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
     *   method?: ?value-of<TransferBetweenBalancesRequestMethod>,
     *   from?: ?value-of<TransferBetweenBalancesRequestFrom>,
     *   to?: ?value-of<TransferBetweenBalancesRequestTo>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->method = $values['method'] ?? null;
        $this->from = $values['from'] ?? null;
        $this->to = $values['to'] ?? null;
        $this->ticker = $values['ticker'];
        $this->amount = $values['amount'];
        $this->request = $values['request'];
        $this->nonce = $values['nonce'];
    }
}
