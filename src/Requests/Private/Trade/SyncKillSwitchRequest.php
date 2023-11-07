<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class SyncKillSwitchRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/order/kill-switch';
    }

    public function __construct(
        protected string $market,
        protected string $timeout,
        protected array $types = [], // TODO: create enum for this
    ) {
    }

    protected function defaultBody(): array
    {
        return [
            'market' => $this->market,
            'timeout' => $this->timeout,
            'types' => $this->types,
        ];
    }
}
