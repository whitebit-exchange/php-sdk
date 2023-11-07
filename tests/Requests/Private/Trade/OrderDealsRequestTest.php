<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\OrderDealsRequest;

it('calls correct endpoint', function () {
    $request = new OrderDealsRequest(
        '1234567890',
        0,
        100
    );

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/trade-account/order')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'orderId' => '1234567890',
            'offset' => 0,
            'limit' => 100,
        ]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/trade-account/order'),
    ]));

    $result = $connector->send(new OrderDealsRequest('1234567890', 0, 100));

    expect($result->status())
        ->toBe(200);
});
