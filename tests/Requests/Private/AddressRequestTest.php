<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\DTO\Response\AddressDTO;
use WhiteBIT\Sdk\Requests\Private\AddressRequest;

it('calls correct endpoint', function () {
    $request = new AddressRequest('WBT', 'WBT');

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/main-account/address')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'ticker' => 'WBT',
            'network' => 'WBT',
        ]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/main-account/address'),
    ]));

    $result = $connector->send(new AddressRequest(
        'WBT',
        'WBT'
    ));

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = createGuardedConnector();
    $request = new AddressRequest(
        'WBT',
    );

    $connector->withMockClient(new MockClient([
        new BasicFixture($request->resolveEndpoint()),
    ]));

    $result = $connector->send($request);

    $raw = $result->json();

    /** @var AddressDTO $dto */
    $dto = $result->dto();

    expect($dto)
        ->toBeInstanceOf(AddressDTO::class)
        ->and($dto->address)
        ->toBe($raw['account']['address'])
        ->and($dto->meta->minAmount)
        ->toBe($raw['required']['minAmount'])
        ->and($dto->meta->fixedFee)
        ->toBe($raw['required']['fixedFee'])
        ->and($dto->meta->maxAmount)
        ->toBe($raw['required']['maxAmount'])
        ->and($dto->meta->flexFee->min)
        ->toBe($raw['required']['flexFee']['minFee'])
        ->and($dto->meta->flexFee->max)
        ->toBe($raw['required']['flexFee']['maxFee'])
        ->and($dto->meta->flexFee->percent)
        ->toBe($raw['required']['flexFee']['percent']);

});
