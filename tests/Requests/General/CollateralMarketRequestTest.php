<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\CollateralMarketsRequest;

it('calls correct endpoint', function () {
    $request = new CollateralMarketsRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/collateral/markets')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/collateral/markets'),
    ]));

    $result = $connector->send(new CollateralMarketsRequest());

    expect($result->status())
        ->toBe(200);
});
