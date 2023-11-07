<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class StatusKillSwitchRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/order/kill-switch/status';
    }

    public function __construct(
        protected ?string $market = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'market' => $this->market,
        ], static fn (mixed $item): bool => $item !== null);
    }
}
