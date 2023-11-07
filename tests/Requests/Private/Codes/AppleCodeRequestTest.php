<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Requests\Private\Codes\ApplyCodeRequest;

it('calls correct endpoint', function () {
    $request = new ApplyCodeRequest(
        'code'
    );

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/main-account/codes/apply')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'code' => 'code',
        ]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/main-account/codes/apply'),
    ]));

    $result = $connector->send(new ApplyCodeRequest('code'));

    expect($result->status())
        ->toBe(200);
});
