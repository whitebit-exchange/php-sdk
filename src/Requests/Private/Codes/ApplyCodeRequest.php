<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Codes;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class ApplyCodeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/codes/apply';
    }

    public function __construct(
        protected string $code,
        protected ?string $passphrase = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'code' => $this->code,
            'passphrase' => $this->passphrase,
        ]);
    }
}
