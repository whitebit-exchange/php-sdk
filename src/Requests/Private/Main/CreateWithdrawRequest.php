<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Main;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateWithdrawRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/withdraw';
    }

    public function __construct(
        protected string $ticker,
        protected string $amount,
        protected string $address,
        protected string $uniqueId,
        protected ?string $memo = null,
        protected ?string $provider = null,
        protected ?string $network = null,
        protected ?string $partialEnable = null,
        protected ?array $beneficiary = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'ticker' => $this->ticker,
            'amount' => $this->amount,
            'address' => $this->address,
            'uniqueId' => $this->uniqueId,
            'memo' => $this->memo,
            'provider' => $this->provider,
            'network' => $this->network,
            'partialEnable' => $this->partialEnable,
            'beneficiary' => $this->beneficiary,
        ]);
    }
}
