<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Main;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\Enums\TransactionMethodEnum;

final class HistoryRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/history';
    }

    public function __construct(
        protected ?TransactionMethodEnum $transactionMethod = null,
        protected ?string $ticker = null,
        ?string $address = null,
        protected ?array $addresses = [],
        protected ?string $uniqueId = null,
        protected ?array $status = [],
        protected ?int $offset = 0,
        protected ?int $limit = 50,
    ) {
        if ($address !== null) {
            $this->addresses[] = $address;
        }
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'transactionMethod' => $this->transactionMethod,
            'ticker' => $this->ticker,
            'addresses' => $this->addresses,
            'uniqueId' => $this->uniqueId,
            'status' => $this->status,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ]);
    }
}
