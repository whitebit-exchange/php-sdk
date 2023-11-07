<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\HealthRequest;

it('calls correct endpoint', function () {
    $request = new HealthRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/ping')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/ping'),
    ]));

    $result = $connector->send(new HealthRequest());

    expect($result->status())
        ->toBe(200);
});
