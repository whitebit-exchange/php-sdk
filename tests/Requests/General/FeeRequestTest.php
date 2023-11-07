<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\FeeRequest;

it('calls correct endpoint', function () {
    $request = new FeeRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/fee')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/fee'),
    ]));

    $result = $connector->send(new FeeRequest());

    expect($result->status())
        ->toBe(200);
});
