<?php

namespace Digikraaft\PaystackSubscriptionsTile;

use Digikraaft\Paystack\Paystack;
use Digikraaft\Paystack\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchSubscriptionsDataFromPaystackApi extends Command
{
    protected $signature = 'dashboard:fetch-subscriptions-data-from-paystack-api';

    protected $description = 'Fetch data for paystack subscriptions tile';

    public function handle()
    {
        Paystack::setApiKey(config('dashboard.tiles.paystack.secret_key', env('PAYSTACK_SECRET')));

        $this->info('Fetching Paystack subscriptions ...');

        $subscriptions = Subscription::list(
            config('dashboard.tiles.paystack.subscriptions.params') ?? [
                'perPage' => 4,
            ]
        );

        $subscriptions = collect($subscriptions->data)
            ->map(function ($subscription) {
                return [
                    'customer' => $subscription->customer->email,
                    'plan' => $subscription->plan->name,
                    'plan_id' => $subscription->plan->id,
                    'plan_interval' => $subscription->plan->interval,
                    'status' => $subscription->status,
                    'start' => $subscription->start,
                    'quantity' => $subscription->quantity,
                    'currency' => $subscription->plan->currency,
                    'subsctiption_code' => $subscription->subscription_code,
                    'amount' => $this->formatMoney($subscription->amount),
                    'next_payment_date' => Carbon::parse($subscription->next_payment_date)
                        ->setTimezone('UTC')
                        ->format("d.m.Y"),
                    'id' => $subscription->id,
                    'createdAt' => Carbon::parse($subscription->createdAt)
                        ->setTimezone('UTC')
                        ->format("d.m.Y"),
                ];
            })->toArray();

        PaystackSubscriptionsStore::make()->setData($subscriptions);

        $this->info('All done!');

        return 0;
    }

    /**
     * @param string $amount
     * @return float
     */
    public function formatMoney(string $amount): string
    {
        return number_format(($amount), 2, '.', ',');
    }
}
