<?php

use Pest\Expectation;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\DTO\Response\AssetDTO;
use WhiteBIT\Sdk\DTO\Response\AssetLimitItemDTO;
use WhiteBIT\Sdk\Requests\General\AssetsRequest;

it('calls correct endpoint', function () {
    $request = new AssetsRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/assets')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/assets'),
    ]));

    $result = $connector->send(new AssetsRequest());

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/assets'),
    ]));

    $result = $connector->send(new AssetsRequest());

    $json = $result->json();
    $raw = array_shift($json);
    /** @var AssetDTO $dto */
    $dto = $result->dto()[0];

    $this->assertTrue($dto instanceof AssetDTO);

    expect($dto->market)
        ->toBe(array_keys($result->json())[0])
        ->and($dto->name)
        ->toBe($raw['name'])
        ->and($dto->makerFee)
        ->toBe($raw['maker_fee'])
        ->and($dto->takerFee)
        ->toBe($raw['taker_fee'])
        ->and($dto->canDeposit)
        ->toBe($raw['can_deposit'])
        ->and($dto->canWithdraw)
        ->toBe($raw['can_withdraw'])
        ->and($dto->currencyPrecision)
        ->toBe($raw['currency_precision'])
        ->and($dto->isMemo)
        ->toBe($raw['is_memo'])
        ->and($dto->maxDeposit)
        ->toBe($raw['max_deposit'])
        ->and($dto->maxWithdraw)
        ->toBe($raw['max_withdraw'])
        ->and($dto->minDeposit)
        ->toBe($raw['min_deposit'])
        ->and($dto->minWithdraw)
        ->toBe($raw['min_withdraw'])
        ->and($dto->unifiedCryptoAssetId)
        ->toBe($raw['unified_cryptoasset_id']);

    $networksCheckedOnce = false;
    if ($raw['networks'] !== null) {
        $networksCheckedOnce = true;

        expect($dto->networks->withdraws)
            ->toBe($raw['networks']['withdraws'])
            ->and($dto->networks->deposits)
            ->toBe($raw['networks']['deposits'])
            ->and($dto->networks->default)
            ->toBe($raw['networks']['default']);
    }

    $limitsCheckedOnce = false;
    if ($raw['limits'] !== null) {
        $limitsCheckedOnce = true;
        $list = ['deposit', 'withdraw'];

        foreach ($list as $type) {
            expect($dto->limits->{$type})
                ->each(function (Expectation $limit, $key) use ($raw, $type) {
                    $limit->toBeInstanceOf(AssetLimitItemDTO::class);
                    $limit = $limit->value;

                    expect($limit->min)
                        ->toBe($raw['limits'][$type][$key]['min'] ?? null)
                        ->and($limit->max)
                        ->toBe($raw['limits'][$type][$key]['max'] ?? null);
                });
        }
    }

    $providersCheckedOnce = false;
    if (($raw['providers'] ?? null) !== null) {
        $providersCheckedOnce = true;

        expect($dto->providers->deposits)
            ->toBe($raw['providers']['deposit'])
            ->and($dto->providers->withdraws)
            ->toBe($raw['providers']['withdraws']);
    }

    expect($providersCheckedOnce)
        ->and($networksCheckedOnce)
        ->and($limitsCheckedOnce)
        ->toBeTrue();
});
