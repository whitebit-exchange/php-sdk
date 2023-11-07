<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\TimeRequest;

it('calls correct endpoint', function () {
    $request = new TimeRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/time')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/time'),
    ]));

    $result = $connector->send(new TimeRequest());

    expect($result->status())
        ->toBe(200);
});
