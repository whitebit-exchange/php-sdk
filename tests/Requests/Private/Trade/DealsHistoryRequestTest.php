<?php

use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\DealsHistoryItemDTO;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\DealsHistoryRequest;

it('calls correct endpoint', function () {
    $request = new DealsHistoryRequest('BTC_USDT', 'orderId', 0, 100);

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/trade-account/executed-history')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'market' => 'BTC_USDT',
            'clientOrderId' => 'orderId',
            'offset' => 0,
            'limit' => 100,
        ]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/trade-account/executed-history'),
    ]));

    $result = $connector->send(new DealsHistoryRequest('BTC_USDT', 'orderId', 0, 100));

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = createGuardedConnector();
    $request = new DealsHistoryRequest();

    $connector->withMockClient(new MockClient([
        new BasicFixture($request->resolveEndpoint()),
    ]));

    $result = $connector->send($request);

    $json = $result->json();
    $raw = array_values($json)[0][0];

    /** @var Collection $collection */
    $collection = $result->dto();

    /** @var DealsHistoryItemDTO $firstItem */
    $firstItem = $collection->first();

    expect($collection)
        ->toBeInstanceOf(Collection::class)
        ->and($firstItem)
        ->toBeInstanceOf(DealsHistoryItemDTO::class)
        ->and($firstItem->market)
        ->toBe(array_keys($json)[0])
        ->and($firstItem->clientOrderId)
        ->toBe($raw['clientOrderId'])
        ->and($firstItem->amount)
        ->toBe($raw['amount'])
        ->and($firstItem->price)
        ->toBe($raw['price'])
        ->and($firstItem->deal)
        ->toBe($raw['deal'])
        ->and($firstItem->fee)
        ->toBe($raw['fee'])
        ->and($firstItem->id)
        ->toBe($raw['id'])
        ->and($firstItem->side)
        ->toBe(OrderTypeEnum::from($raw['side']))
        ->and($firstItem->role)
        ->toBe($raw['role'])
        ->and($firstItem->time)
        ->toBe($raw['time'])
        ->and($firstItem->market)
        ->toBe(array_keys($json)[0]);

});
