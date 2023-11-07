<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade\Spot;

use Illuminate\Support\Collection;
use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\DealsHistoryItemDTO;

final class DealsHistoryRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/trade-account/executed-history';
    }

    public function __construct(
        protected ?string $market = null,
        protected ?string $clientOrderId = null,
        protected ?int $offset = null,
        protected ?int $limit = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'market' => $this->market,
            'clientOrderId' => $this->clientOrderId,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $item): bool => $item !== null);
    }

    /**
     * @return Collection<DealsHistoryItemDTO>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        $markets = $response->json();
        $result = new Collection();

        foreach ($markets as $market => $marketData) {
            foreach ($marketData as $payload) {
                $result[] = DealsHistoryItemDTO::fromResponseJson($market, $payload);
            }
        }

        return $result;
    }
}
