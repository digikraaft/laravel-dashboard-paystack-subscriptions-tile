<?php

namespace Digikraaft\PaystackSubscriptionsTile;

use Spatie\Dashboard\Models\Tile;

class PaystackSubscriptionsStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("paystackSubscriptions");
    }

    public function setData(array $data): self
    {
        $this->tile->putData('paystack.subscriptions', $data);

        return $this;
    }

    public function getData(): array
    {
        return $this->tile->getData('paystack.subscriptions') ?? [];
    }
}
