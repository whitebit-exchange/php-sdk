<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Codes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class CreateCodeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/codes';
    }

    public function __construct(
        protected string $ticker,
        protected string $amount,
        protected ?string $passphrase = null,
        protected ?string $description = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'ticker' => $this->ticker,
            'amount' => $this->amount,
            'passphrase' => $this->passphrase,
            'description' => $this->description,
        ]);
    }
}
