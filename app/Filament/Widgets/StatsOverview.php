<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use App\Models\PageView;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Views', PageView::count())
                ->description('Total views across all pages')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
            Stat::make('Pending Inquiries', ContactInquiry::whereNotNull('service')->where('status', 'new')->count())
                ->description('Inquiries awaiting response')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),
            Stat::make('Unread Contacts', ContactInquiry::where('status', 'new')->count())
                ->description('Contacts pending review')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),
        ];
    }
}
