<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\Product;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pendapatan Hari Ini', 'IDR ' . number_format(Order::whereDate('created_at', today())->sum('total_price')))
            ->description('Total omzet dari semua meja')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
        Stat::make('Pesanan Aktif', Order::whereIn('status', ['pending', 'processing'])->count())
            ->description('Pesanan yang harus segera diproses')
            ->color('warning'),
        ];
    }
}
    