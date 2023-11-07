<?php

use WhiteBIT\Sdk\Exceptions\Webhook\WebhookValidationException;
use WhiteBIT\Sdk\Exceptions\Webhook\WebhookValidationMessage;
use WhiteBIT\Sdk\Webhook\WebhookValidator;

function createWebhookValidator(): WebhookValidator
{
    return new WebhookValidator(
        'key',
        'secret'
    );
}

it('fails if payload is empty', function () {
    $validator = createWebhookValidator();

    $validator->validate(
        '',
        'encodedPayload',
        '123',
        '123'
    );
})->throws(WebhookValidationException::class, WebhookValidationMessage::INVALID_PAYLOAD->value);

it('fails if payload doesnt include method and params', function () {
    $payload = json_encode(
        [
            'test' => 'test',
        ]
    );

    $validator = createWebhookValidator();

    $validator->validate($payload,
        'encodedPayload',
        '123',
        '123'
    );
})->throws(WebhookValidationException::class, WebhookValidationMessage::REQUIRED_PAYLOAD_FIELDS_ARE_MISSING->value);

it('fails if header key is wrong', function () {
    $payload = json_encode(
        [
            'params' => [],
            'method' => 'test',
        ]
    );

    $validator = createWebhookValidator();

    $validator->validate($payload,
        'encodedPayload',
        '123',
        '123'
    );
})->throws(WebhookValidationException::class, WebhookValidationMessage::INVALID_KEY->value);

it('fails if encoded header is wrong', function () {
    $payload = json_encode(
        [
            'params' => [],
            'method' => 'test',
        ]
    );

    $validator = createWebhookValidator();

    $validator->validate($payload,
        'encodedPayload',
        '123',
        'key'
    );
})->throws(WebhookValidationException::class, WebhookValidationMessage::INVALID_PAYLOAD->value);

it('fails if signature is incorrect', function () {
    $payload = json_encode(
        [
            'params' => [],
            'method' => 'test',
        ]
    );

    $validator = createWebhookValidator();

    $validator->validate($payload,
        base64_encode($payload),
        '123',
        'key'
    );
})->throws(WebhookValidationException::class, WebhookValidationMessage::INVALID_SIGNATURE->value);

it('works as expected', function () {
    $payload = json_encode(
        [
            'params' => [],
            'method' => 'test',
        ]
    );

    $validator = createWebhookValidator();

    $encodedPayload = base64_encode($payload);
    $signature = hash_hmac('sha512', $encodedPayload, 'secret');

    $result = $validator->validate($payload,
        $encodedPayload,
        $signature,
        'key'
    );

    expect($result)->toBeTrue();
});
