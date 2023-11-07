<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Exceptions\Webhook;

enum WebhookValidationMessage: string
{
    case INVALID_PAYLOAD = 'Invalid payload';
    case REQUIRED_PAYLOAD_FIELDS_ARE_MISSING = '`params` or `method` fields are missing';
    case INVALID_KEY = 'Invalid key';
    case INVALID_PAYLOAD_HASH = 'Invalid payload hash';
    case INVALID_SIGNATURE = 'Invalid signature';
}
