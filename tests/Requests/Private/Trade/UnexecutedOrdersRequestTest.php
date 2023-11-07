<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\UnexecutedOrdersRequest;

it('calls correct endpoint', function () {
    $request = new UnexecutedOrdersRequest(
        'BTC_USDT',
        '1234567890',
        '1234567890',
        0,
        100
    );

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/orders')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'offset' => 0,
            'limit' => 100,
            'market' => 'BTC_USDT',
            'orderId' => '1234567890',
            'clientOrderId' => '1234567890',
        ]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/orders'),
    ]));

    $result = $connector->send(new UnexecutedOrdersRequest('BTC_USDT', '1234567890', '1234567890', 0, 100));

    expect($result->status())
        ->toBe(200);
});
