<?php

namespace Digikraaft\PaystackSubscriptionsTile;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class PaystackSubscriptionsTileComponent extends Component
{
    use WithPagination;

    /** @var string */
    public string $position;

    /** @var string|null */
    public ?string $title;

    public $perPage;

    /** @var int|null */
    public ?int $refreshInSeconds;

    public function mount(string $position, $perPage = 5, ?string $title = null, int $refreshInSeconds = null)
    {
        $this->position = $position;
        $this->perPage = $perPage;
        $this->title = $title;
        $this->refreshInSeconds = $refreshInSeconds;
    }

    public function render()
    {
        $subscriptions = collect(PaystackSubscriptionsStore::make()->getData());
        $paginator = $this->getPaginator($subscriptions);

        return view('dashboard-paystack-subscriptions-tile::tile', [
            'subscriptions' => $subscriptions->skip(($paginator->firstItem() ?? 1) - 1)->take($paginator->perPage()),
            'paginator' => $paginator,
            'refreshIntervalInSeconds' => $this->refreshInSeconds ?? config('dashboard.tiles.paystack.subscriptions.refresh_interval_in_seconds') ?? 1800,
        ]);
    }

    public function getPaginator(Collection $subscriptions): LengthAwarePaginator
    {
        return new LengthAwarePaginator($subscriptions, $subscriptions->count(), $this->perPage, $this->page);
    }

    public function paginationView()
    {
        return 'dashboard-paystack-subscriptions-tile::pagination';
    }
}
