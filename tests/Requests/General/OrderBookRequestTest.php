<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\OrderBookRequest;

it('calls correct endpoint', function () {
    $request = new OrderBookRequest('BTC_USDT', 1, 100);

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/orderbook/BTC_USDT')
        ->and($request->getMethod())
        ->toBe(Method::GET)
        ->and($request->query()->all())
        ->toBe([
            'depth' => 1,
            'limit' => 100,
        ]);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/orderbook/BTC_USDT'),
    ]));

    $result = $connector->send(new OrderBookRequest('BTC_USDT'));

    expect($result->status())
        ->toBe(200);
});

it('throws error if depth < 0', function () {
    new OrderBookRequest('BTC_USDT', -1);
})->throws(LogicException::class);

it('throws error if depth > 5', function () {
    new OrderBookRequest('BTC_USDT', 6);
})->throws(LogicException::class);
