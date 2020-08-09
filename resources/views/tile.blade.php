<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="grid grid-rows-auto-1 gap-2 h-auto">
        @isset($title)
            <h1 class="font-bold">
                {{ $title }} <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @else
            <h1 class="font-bold">
                Paystack Subscriptions <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @endisset
        <ul class="self-center divide-y-2 divide-canvas">
            @foreach($subscriptions as $subscription)
                <li class="py-1">
                    <div class="my-2">
                        <div class="font-bold">
                            Plan: <a href="https://dashboard.paystack.com/#/plans/{{ $subscription['plan_id'] }}" target="_blank">
                            {{ $subscription['plan'] }} ({{$subscription['plan_interval']}})
                            </a>
                        </div>
                        <div class="text-sm {{ ($subscription['status']=='active')? 'text-green-700' : 'text-red-700' }}">
                            Status: {{ $subscription['status'] }}
                        </div>
                        <div class="text-sm text-dimmed">
                            Customer:
                            <a href="mailto:{{$subscription['customer']}}">
                                {{$subscription['customer']}}
                            </a>
                        </div>
                        <div class="text-sm">
                            Amount: {{ $subscription['currency'] }} {{ $subscription['amount'] }}
                        </div>
                        <div class="text-sm text-dimmed">
                            Next Payment: {{$subscription['next_payment_date']}}
                        </div>
                        <div class="text-sm text-dimmed">
                            Created: {{$subscription['createdAt']}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{$paginator}}
    </div>
</x-dashboard-tile>
