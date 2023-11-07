<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\FutureMarketsRequest;

it('calls correct endpoint', function () {
    $request = new FutureMarketsRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/futures')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/futures'),
    ]));

    $result = $connector->send(new FutureMarketsRequest());

    expect($result->status())
        ->toBe(200);
});
