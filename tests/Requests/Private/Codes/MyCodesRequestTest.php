<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Requests\Private\Codes\MyCodesRequest;

it('calls correct endpoint', function () {
    $request = new MyCodesRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/main-account/codes/my')
        ->and($request->getMethod())
        ->toBe(Method::POST);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/main-account/codes/my'),
    ]));

    $result = $connector->send(new MyCodesRequest());

    expect($result->status())
        ->toBe(200);
});
