<?php

use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\DTO\InputLimitOrderDTO;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\SpotOrderDTO;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CreateBulkLimitOrderRequest;

it('calls correct endpoint', function () {
    $request = new CreateBulkLimitOrderRequest([
        new InputLimitOrderDTO(
            'WBT_USDT',
            OrderTypeEnum::BUY,
            '6',
            '2'
        ),
    ]);

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/order/bulk')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'orders' => [
                [
                    'market' => 'WBT_USDT',
                    'side' => OrderTypeEnum::BUY->value,
                    'amount' => '6',
                    'price' => '2',
                ],
            ],
        ]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/order/bulk'),
    ]));

    $result = $connector->send(new CreateBulkLimitOrderRequest([
        new InputLimitOrderDTO(
            'WBT_USDT',
            OrderTypeEnum::BUY,
            '6',
            '2'
        ),
    ]));

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = createGuardedConnector();
    $request = new CreateBulkLimitOrderRequest([
        new InputLimitOrderDTO(
            'WBT_USDT',
            OrderTypeEnum::BUY,
            '6',
            '2'
        ),
    ]);

    $connector->withMockClient(new MockClient([
        new BasicFixture($request->resolveEndpoint()),
    ]));

    $result = $connector->send($request);

    $json = $result->json();

    /** @var Collection $collection */
    $collection = $result->dto();

    expect($collection)
        ->toBeInstanceOf(Collection::class);

    foreach ($collection as $index => $dto) {
        $raw = $json[$index]['result'];

        expect($dto)
            ->toBeInstanceOf(SpotOrderDTO::class)
            ->and($dto->market)
            ->toBe($raw['market'])
            ->and($dto->orderId)
            ->toBe($raw['orderId'])
            ->and($dto->clientOrderId)
            ->toBe($raw['clientOrderId'])
            ->and($dto->side)
            ->toBe(OrderTypeEnum::from($raw['side']))
            ->and($dto->type)
            ->toBe($raw['type'])
            ->and($dto->timestamp)
            ->toBe($raw['timestamp'])
            ->and($dto->dealMoney)
            ->toBe($raw['dealMoney'])
            ->and($dto->dealStock)
            ->toBe($raw['dealStock'])
            ->and($dto->amount)
            ->toBe($raw['amount'])
            ->and($dto->takerFee)
            ->toBe($raw['takerFee'])
            ->and($dto->makerFee)
            ->toBe($raw['makerFee'])
            ->and($dto->left)
            ->toBe($raw['left'])
            ->and($dto->dealFee)
            ->toBe($raw['dealFee'])
            ->and($dto->price)
            ->toBe($raw['price'])
            ->and($dto->postOnly)
            ->toBe($raw['postOnly'])
            ->and($dto->ioc)
            ->toBe($raw['ioc'])
            ->and($dto->activationPrice)
            ->toBe(null);
    }
});
