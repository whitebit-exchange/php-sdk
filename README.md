<h1 align="center">WhiteBit PHP SDK</h1>

<p align="center">
  <strong>Official PHP SDK for the WhiteBit API — trade, query, and manage your crypto portfolio programmatically.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-≥ 8.1-777BB4?style=flat-square&logo=php" alt="PHP ≥ 8.1" />
  <img src="https://img.shields.io/badge/license-Apache_2.0-green?style=flat-square" alt="Apache 2.0 license" />
</p>

---

## Prerequisites

| Requirement | Details |
|-------------|---------|
| **PHP ≥ 8.1** | Required runtime |
| **WhiteBit account** | Sign up at [whitebit.com](https://whitebit.com) |
| **WhiteBit API key** | Profile → API keys → Create key (Read and/or Trade permissions) |

---

## Installation

```bash
composer require whitebit-exchange/php-sdk
```

---

## Quick Start

### 1. Get your API credentials

1. Log in to [whitebit.com](https://whitebit.com) → **Profile → API keys**
2. Create a new key — choose **Read** and/or **Trade** permissions as needed
3. Copy your **API Key** and **Token**

> Public endpoints (market data, tickers, order book) work without credentials. Private endpoints (account, trading) require both.

### 2. Initialize the client

**Public endpoints only** (market data, tickers, order book):

```php
use Whitebit\WhitebitClient;

$client = new WhitebitClient(token: "", txcApikey: "");
```

**Private endpoints** (account, trading — requires HMAC signing):

```php
use Whitebit\WhitebitClient;
use Whitebit\Auth\HmacClient;

$client = new WhitebitClient(
    token: "",
    txcApikey: "YOUR_API_KEY",
    options: ['client' => new HmacClient("YOUR_API_SECRET")],
);
```

> **Note:** WhiteBit private endpoints use HMAC-SHA512 signing (`X-TXC-PAYLOAD` + `X-TXC-SIGNATURE`).
> `HmacClient` handles this automatically — no manual signing needed.
```

---

## Usage Examples

```php
// Market data (no credentials required)
$tickers = $client->publicApiV4->getMarketActivity();
$depth   = $client->publicApiV4->getOrderbook(new GetOrderbookRequest(market: "BTC_USDT"));

// Account
$balance = $client->accountEndpoints->getTradingBalance();

// Spot trading
$order   = $client->spotTrading->createLimitOrder(
    new CreateLimitOrderRequest(
        market: "BTC_USDT", side: "buy", amount: "0.01", price: "95000"
    )
);
$client->spotTrading->cancelOrder(
    new CancelOrderRequest(market: "BTC_USDT", orderId: $order->orderId)
);

// Main account — transfer & withdraw
$client->transfer->transfer(new TransferRequest(from: "main", to: "spot", ticker: "USDT", amount: "100"));
$client->withdraw->createWithdraw(new CreateWithdrawRequest(ticker: "USDT", amount: "500", address: "0x..."));
```

---

## Available Modules

| Module | Description |
|--------|-------------|
| `publicApiV4` | Tickers, order book, trade history, klines, assets |
| `spotTrading` | Limit, market, stop-limit, stop-market, bulk orders |
| `collateralTrading` | Collateral orders, OCO, positions |
| `accountEndpoints` | Trading balance, open orders, order history |
| `mainAccount` | Main balances, deposit addresses, fee info |
| `transfer` | Transfer between main and trade accounts |
| `withdraw` | Withdrawal requests |
| `codes` | WhiteBit codes — create, apply, history |
| `fees` | Trading fees |
| `subAccount` | Sub-account management |

---

## Resources

| | |
|---|---|
| [WhiteBIT API Documentation](https://docs.whitebit.com) | Official API reference |
| [API Platform Overview](https://docs.whitebit.com/private/http-trade-v4/) | REST, WebSocket, authentication, rate limits |
| [Use with AI](https://github.com/whitebit-exchange/whitebit-mcp) | Use API docs with Claude, Cursor, VS Code via MCP |
| [GitHub Repository](https://github.com/whitebit-exchange/php-sdk) | Source code |
| [Releases](https://github.com/whitebit-exchange/php-sdk/releases) | Binaries and changelog |
| [Contributing](CONTRIBUTING.md) | Development setup and contribution guide |
| [Report an Issue](https://github.com/whitebit-exchange/php-sdk/issues) | Bug reports and feature requests |
| [WhiteBIT Exchange](https://whitebit.com) | The exchange |

---

## License

[Apache 2.0](LICENSE.md)
