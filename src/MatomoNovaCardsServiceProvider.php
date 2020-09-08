<?php

namespace Adeweb\NovaMatomoCards;

use Illuminate\Support\ServiceProvider;

class NovaMatomoCardsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/nova-matomo-cards.php' => config_path('nova-matomo-cards.php'),
            ], 'config');
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'nova_matomo_cards');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-matomo-cards.php', 'nova-matomo-cards');
    }
}
