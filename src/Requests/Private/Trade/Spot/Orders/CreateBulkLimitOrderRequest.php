<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders;

use Illuminate\Support\Collection;
use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\DTO\InputLimitOrderDTO;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\SpotOrderDTO;

final class CreateBulkLimitOrderRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/order/bulk';
    }

    /**
     * @param  array<InputLimitOrderDTO>  $limitOrders
     *
     * @throws \Exception
     */
    public function __construct(
        protected array $limitOrders
    ) {
    }

    protected function defaultBody(): array
    {
        return [
            'orders' => array_map(
                static fn (InputLimitOrderDTO $limitOrder): array => $limitOrder->toArray(),
                $this->limitOrders
            ),
        ];
    }

    /**
     * @return Collection<SpotOrderDTO>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return new Collection(
            array_map(
                static function (array $item): SpotOrderDTO {
                    return SpotOrderDTO::fromResponseJson($item['result']);
                },
                $response->json()
            )
        );
    }
}
