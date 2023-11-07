<?php

namespace Tests\Fixtures\WhiteBIT;

use Saloon\Http\Faking\Fixture;

class BasicFixture extends Fixture
{
    protected function defineName(): string
    {
        return $this->name;
    }

    protected function defineSensitiveJsonParameters(): array
    {
        return [
            'timestamp' => (new \DateTime('now'))->getTimestamp(),
            'code' => 'REDACTED',
            'external_id' => 'REDACTED',
            'id' => 1234567890,
        ];
    }

    protected function defineSensitiveHeaders(): array
    {
        return [
            'Set-Cookie' => 'REDACTED',
            'Date' => 'REDACTED',
            'CF-Ray' => 'REDACTED',
        ];
    }
}
