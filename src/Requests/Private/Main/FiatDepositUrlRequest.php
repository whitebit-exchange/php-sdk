<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Main;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class FiatDepositUrlRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/fiat-deposit-url';
    }

    public function __construct(
        protected string $ticker,
        protected string $provider,
        protected string $amount,
        protected string $uniqueId,
        protected ?array $customer = null,
        protected ?string $successLink = null,
        protected ?string $failureLink = null,
        protected ?string $returnLink = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'ticker' => $this->ticker,
            'provider' => $this->provider,
            'amount' => $this->amount,
            'uniqueId' => $this->uniqueId,
            'customer' => $this->customer,
            'successLink' => $this->successLink,
            'failureLink' => $this->failureLink,
            'returnLink' => $this->returnLink,
        ], static fn (mixed $item): bool => $item !== null);
    }
}
