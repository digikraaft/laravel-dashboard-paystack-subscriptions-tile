<?php

namespace Digikraaft\PaystackSubscriptionsTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class PaystackSubscriptionsTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchSubscriptionsDataFromPaystackApi::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/paystack-subscriptions-tile'),
        ], 'paystack-subscriptions-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-paystack-subscriptions-tile');

        Livewire::component('paystack-subscriptions-tile', PaystackSubscriptionsTileComponent::class);
    }
}
