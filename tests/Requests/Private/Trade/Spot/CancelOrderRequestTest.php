<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\SpotOrderDTO;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CancelOrderRequest;

it('calls correct endpoint', function () {
    $request = new CancelOrderRequest(
        'WBT_USDT',
        '1234567890',
    );

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/order/cancel')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'market' => 'WBT_USDT',
            'orderId' => '1234567890',
        ]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/order/cancel'),
    ]));

    $result = $connector->send(new CancelOrderRequest('WBT_USDT', '1234567890'));

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = createGuardedConnector();
    $request = new CancelOrderRequest(
        'WBT_USDT',
        '1234567890',
    );

    $connector->withMockClient(new MockClient([
        new BasicFixture($request->resolveEndpoint()),
    ]));

    $result = $connector->send($request);

    $raw = $result->json();

    /** @var SpotOrderDTO $collection */
    $dto = $result->dto();

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
});
