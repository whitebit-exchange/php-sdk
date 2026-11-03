<?php

namespace Whitebit\Auth;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;

/**
 * PSR-18 client decorator that injects WhiteBit HMAC authentication headers
 * (X-TXC-PAYLOAD, X-TXC-SIGNATURE) into every POST request before it is sent.
 *
 * Usage:
 *   use Whitebit\Auth\HmacClient;
 *   use Whitebit\WhitebitClient;
 *
 *   $client = new WhitebitClient(
 *       apiKey:      'YOUR_API_KEY',
 *       txcPayload:  '',
 *       txcSignature: '',
 *       options:     ['client' => new HmacClient('YOUR_API_SECRET')],
 *   );
 */
class HmacClient implements ClientInterface
{
    private ClientInterface $inner;
    private StreamFactoryInterface $streamFactory;
    private string $apiSecret;

    public function __construct(
        string $apiSecret,
        ?ClientInterface $inner = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        $this->apiSecret     = $apiSecret;
        $this->inner         = $inner         ?? Psr18ClientDiscovery::find();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        if (strtoupper($request->getMethod()) !== 'POST' || !str_starts_with($path, '/api/v4/')) {
            return $this->inner->sendRequest($request);
        }

        $rawBody = (string) $request->getBody();
        if ($rawBody === '') {
            return $this->inner->sendRequest($request);
        }

        $body = json_decode($rawBody, true);
        if (!is_array($body)) {
            return $this->inner->sendRequest($request);
        }
        // request/nonce: fill if falsy (empty()), not just if absent (??=).
        // Some endpoints' generated request bodies declare request/nonce as
        // required (OpenAPI marks them required for the wire contract, since
        // they're mandatory for non-SDK callers), so the SDK always
        // serializes them — even as '' / 0 — which ??= would never touch
        // since the key is already present. '' and 0 are never legitimate
        // caller-supplied values for these two fields, so treating them as
        // absent is safe and still lets an explicitly-set nonce survive.
        if (empty($body['request'])) {
            $body['request'] = $path;
        }
        if (empty($body['nonce'])) {
            $body['nonce'] = (int) (microtime(true) * 1000);
        }
        // nonceWindow is genuinely optional in every spec and defaults to
        // false server-side — an explicit `nonceWindow: false` from the
        // caller must survive, so only fill it in when the key is missing
        // or null (empty() would incorrectly also match `false`).
        if (!array_key_exists('nonceWindow', $body) || $body['nonceWindow'] === null) {
            $body['nonceWindow'] = true;
        }

        $newRaw   = json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $payload  = base64_encode($newRaw);
        $signature = hash_hmac('sha512', $payload, $this->apiSecret);

        $newRequest = $request
            ->withBody($this->streamFactory->createStream($newRaw))
            ->withHeader('X-TXC-PAYLOAD',   $payload)
            ->withHeader('X-TXC-SIGNATURE', $signature)
            ->withHeader('Content-Length',  (string) strlen($newRaw));

        return $this->inner->sendRequest($newRequest);
    }
}
