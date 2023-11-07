<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Requests\Private\Codes\CreateCodeRequest;

it('calls correct endpoint', function () {
    $request = new CreateCodeRequest(
        'ticker',
        '100'
    );

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/main-account/codes')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'ticker' => 'ticker',
            'amount' => '100',
        ]);

});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/main-account/codes'),
    ]));

    $result = $connector->send(new CreateCodeRequest('ticker', '100'));

    expect($result->status())
        ->toBe(201);
});
