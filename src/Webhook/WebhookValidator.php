<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Webhook;

use WhiteBIT\Sdk\Exceptions\Webhook\WebhookValidationException;
use WhiteBIT\Sdk\Exceptions\Webhook\WebhookValidationMessage;

final class WebhookValidator
{
    public function __construct(protected string $key, protected string $secret)
    {
    }

    public function validate(
        string $body,
        string $headerEncodedPayload,
        string $headerSignature,
        string $headerKey,
    ): bool {
        $payload = json_decode($body, true);

        if ($payload === null) {
            throw WebhookValidationException::make(
                WebhookValidationMessage::INVALID_PAYLOAD
            );
        }

        if (! isset($payload['method']) || ! isset($payload['params'])) {
            throw WebhookValidationException::make(
                WebhookValidationMessage::REQUIRED_PAYLOAD_FIELDS_ARE_MISSING
            );
        }

        if ($this->key !== $headerKey) {
            throw WebhookValidationException::make(
                WebhookValidationMessage::INVALID_KEY
            );
        }

        $encodedBody = base64_encode($body);

        if ($encodedBody !== $headerEncodedPayload) {
            throw WebhookValidationException::make(
                WebhookValidationMessage::INVALID_PAYLOAD_HASH
            );
        }

        $signature = hash_hmac('sha512', $encodedBody, $this->secret);

        if ($signature !== $headerSignature) {
            throw WebhookValidationException::make(
                WebhookValidationMessage::INVALID_SIGNATURE
            );
        }

        return true;
    }
}
