<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Exceptions\Webhook;

final class WebhookValidationException extends \Exception
{
    public static function make(WebhookValidationMessage $message): self
    {
        return new self($message->value);
    }
}
