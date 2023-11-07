<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use WhiteBIT\Sdk\Connectors\ConnectorConfig;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;

final class WhiteBITServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/whitebit.php' => $this->app->configPath('whitebit.php'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/whitebit.php', 'whitebit'
        );

        $this->app->singleton(
            WhiteBITConnector::class,
            function (): WhiteBITConnector {
                /** @var Repository $configRepository */
                $configRepository = $this->app->make(Repository::class);

                return new WhiteBITConnector(
                    new ConnectorConfig(
                        $configRepository->get('whitebit.public_key'),
                        $configRepository->get('whitebit.secret_key'),
                        $configRepository->get('whitebit.timeout'),
                        $configRepository->get('whitebit.base_url'),
                    )
                );
            }
        );
    }
}
