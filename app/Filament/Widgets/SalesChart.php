<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Carbon\Carbon;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Sales Chart';

    protected function getData(): array
    {
        return [
            $data = Order::select('created_at', 'total_price')
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->get()
            ->groupBy(fn($order) => $order->created_at->format('Y-m-d'))
            ->map(fn($orders) => $orders->sum('total_price'))
            ->toArray(),
            
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
