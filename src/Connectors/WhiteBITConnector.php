<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Connectors;

use Saloon\Contracts\Body\BodyRepository;
use Saloon\Contracts\PendingRequest;
use Saloon\Http\Connector;

final class WhiteBITConnector extends Connector
{
    private bool $nonceWindow = true;

    public function __construct(
        protected ?ConnectorConfig $connectorConfig = null
    ) {
        if (! $this->connectorConfig instanceof \WhiteBIT\Sdk\Connectors\ConnectorConfig) {
            $this->connectorConfig = new ConnectorConfig;
        }
    }

    public function setConnectorConfig(ConnectorConfig $connectorConfig): self
    {
        $this->connectorConfig = $connectorConfig;

        return $this;
    }

    public function resolveBaseUrl(): string
    {
        return $this->connectorConfig->baseUrl;
    }

    public function boot(PendingRequest $pendingRequest): void
    {
        if ($pendingRequest->body() instanceof BodyRepository) {
            $path = $pendingRequest->getRequest()->resolveEndpoint();
            $body = $pendingRequest->body();
            $data = array_merge($body->all(), [
                'request' => $path,
                'nonce' => $this->connectorConfig->resolveNonce(),
                'nonceWindow' => $this->nonceWindow,
            ]);

            $payloadHash = base64_encode(
                json_encode($data, JSON_UNESCAPED_SLASHES)
            );
            $signature = hash_hmac('sha512', $payloadHash, $this->connectorConfig->secret);

            $pendingRequest->headers()->merge([
                'X-TXC-APIKEY' => $this->connectorConfig->key,
                'X-TXC-PAYLOAD' => $payloadHash,
                'X-TXC-SIGNATURE' => $signature,
            ]);

            $pendingRequest->body()->set($data);
        }
    }
}
