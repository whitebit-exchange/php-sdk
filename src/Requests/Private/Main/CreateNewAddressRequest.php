<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Main;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class CreateNewAddressRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/create-new-address';
    }

    public function __construct(
        protected string $ticker,
        protected ?string $network = null,
        protected ?string $type = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'ticker' => $this->ticker,
            'network' => $this->network,
            'type' => $this->type,
        ]);
    }
}
