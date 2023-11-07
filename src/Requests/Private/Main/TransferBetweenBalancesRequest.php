<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Main;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\Enums\TransferDirectionEnum;

final class TransferBetweenBalancesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/transfer';
    }

    public function __construct(
        protected string $amount,
        protected TransferDirectionEnum $from,
        protected TransferDirectionEnum $to,
        protected string $ticker,
    ) {
    }

    protected function defaultBody(): array
    {
        return [
            'amount' => $this->amount,
            'from' => $this->from,
            'to' => $this->to,
            'ticker' => $this->ticker,
        ];
    }
}
