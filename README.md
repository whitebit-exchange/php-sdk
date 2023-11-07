# WhiteBIT PHP SDK

[![Latest Version](https://img.shields.io/packagist/v/whitebit/php.svg)](https://packagist.org/packages/whitebit/php)
[![License](https://img.shields.io/github/license/whitebit/php.svg)](LICENSE)

Official PHP SDK for the [WhiteBIT](https://whitebit.com/) API. ([WhiteBIT API Documentation](docs.whitebit.com))

## Requirements
* `PHP 8.2` or higher

## Installation

You can install this SDK via [Composer](https://getcomposer.org/):

```bash
composer require whitebit/php
```

## Usage

### Plain PHP with autoload
```php
<?php

use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Connectors\ConnectorConfig;
use WhiteBIT\Sdk\Requests\General\V1\KlineRequest;

$connector = new WhiteBITConnector(
    new ConnectorConfig('api_key', 'api_secret')
);

$connector->send(new KlineRequest('BTC_USDT'))
```

### Laravel
Package automatically injects `WhiteBITServiceProvider.php` into your app.

#### Publish config
```shell
php artisan vendor:publish --provider="WhiteBIT\Sdk\WhiteBITServiceProvider"
```

### Environment variables
```dotenv
WHITEBIT_PUBLIC_KEY=
WHITEBIT_SECRET_KEY=
```

#### Usage
```php
namespace App\Http\Controllers;
 
use Illuminate\View\View;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\V1\KlineRequest;
 
class ExampleController extends Controller
{

    public function show(WhiteBITConnector $connector): View
    {
        $response = $connector->send(new KlineRequest('BTC_USDT'));
    
        return response()->json(
            $response->json()
        );
    }
}
```

#### Notes
`WhiteBITServiceProvider` registers `WhiteBITConnector` as singleton, use it with care in runtimes like `openswoole`, `roadrunner` etc.

## Available requests

```
Requests
├── General
│   ├── AssetsRequest.php
│   ├── CollateralMarketsRequest.php
│   ├── FeeRequest.php
│   ├── FutureMarketsRequest.php
│   ├── HealthRequest.php
│   ├── MarketActivityRequest.php
│   ├── MarketsRequest.php
│   ├── OrderBookRequest.php
│   ├── TimeRequest.php
│   ├── TradesRequest.php
│   └── V1
│       ├── KlineRequest.php
│       ├── MarketActivityRequest.php
│       ├── SingleMarketActivityRequest.php
│       └── TradeHistoryRequest.php
└── Private
    ├── AddressRequest.php
    ├── Codes
    │   ├── ApplyCodeRequest.php
    │   ├── CodesHistoryRequest.php
    │   ├── CreateCodeRequest.php
    │   └── MyCodesRequest.php
    ├── Main
    │   ├── CreateNewAddressRequest.php
    │   ├── CreateWithdrawPayRequest.php
    │   ├── CreateWithdrawRequest.php
    │   ├── FiatDepositUrlRequest.php
    │   ├── HistoryRequest.php
    │   └── TransferBetweenBalancesRequest.php
    ├── MainBalanceRequest.php
    └── Trade
        ├── Spot
        │   ├── DealsHistoryRequest.php
        │   ├── OrderDealsRequest.php
        │   ├── OrderHistoryRequest.php
        │   ├── Orders
        │   │   ├── CancelOrderRequest.php
        │   │   ├── CreateBulkLimitOrderRequest.php
        │   │   ├── CreateLimitOrderRequest.php
        │   │   ├── CreateMarketOrderRequest.php
        │   │   ├── CreateStockMarketOrderRequest.php
        │   │   ├── CreateStopLimitOrderRequest.php
        │   │   └── CreateStopMarketOrderRequest.php
        │   └── UnexecutedOrdersRequest.php
        ├── StatusKillSwitchRequest.php
        ├── SyncKillSwitchRequest.php
        └── TradeBalanceRequest.php
```