<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Requests\Private\Codes\CodesHistoryRequest;

it('calls correct endpoint', function () {
    $request = new CodesHistoryRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/main-account/codes/history')
        ->and($request->getMethod())
        ->toBe(Method::POST);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/main-account/codes/history'),
    ]));

    $result = $connector->send(new CodesHistoryRequest());

    expect($result->status())
        ->toBe(200);
});
