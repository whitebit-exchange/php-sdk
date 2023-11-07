<?php

use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\DTO\Response\MainBalanceDTO;
use WhiteBIT\Sdk\Requests\Private\MainBalanceRequest;

it('calls correct endpoint', function () {
    $request = new MainBalanceRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/main-account/balance')
        ->and($request->getMethod())
        ->toBe(Method::POST);
});

it('returns correct DTO response', function () {
    $connector = createGuardedConnector();
    $request = new MainBalanceRequest();

    $connector->withMockClient(new MockClient([
        new BasicFixture($request->resolveEndpoint()),
    ]));

    $result = $connector->send($request);

    $json = $result->json();
    $raw = array_values($json)[0];

    /** @var Collection $collection */
    $collection = $result->dto();

    /** @var MainBalanceDTO $firstItem */
    $firstItem = $collection->first();

    expect($collection)
        ->toBeInstanceOf(Collection::class)
        ->and($firstItem)
        ->toBeInstanceOf(MainBalanceDTO::class)
        ->and($firstItem->mainBalance)
        ->toBe($raw['main_balance'])
        ->and($firstItem->ticker)
        ->toBe(array_keys($json)[0]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/main-account/balance'),
    ]));

    $result = $connector->send(new MainBalanceRequest());

    expect($result->status())
        ->toBe(200);
});
