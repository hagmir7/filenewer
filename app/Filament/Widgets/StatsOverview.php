<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Page;
use App\Models\Tool;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '30s'; // ✅ no "static"

    protected ?string $heading = 'Overview';

    protected ?string $description = 'A summary of your site content and users.';

    protected function getStats(): array
    {
        $totalTools     = Tool::count();
        $activeTools    = Tool::where('is_active', true)->count();

        $totalBlogs     = Blog::count();
        $publishedBlogs = Blog::where('is_published', true)->count();

        $totalPages     = Page::count();
        $publishedPages = Page::where('is_published', true)->count();

        $totalUsers     = User::count();
        $newUsers       = User::whereDate('created_at', '>=', now()->subDays(30))->count();

        return [
            Stat::make('Tools', $totalTools)
                ->description($activeTools . ' Active tools')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('success'),

            Stat::make('Blog Posts', $totalBlogs)
                ->description($publishedBlogs . ' Published posts')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('info'),

            Stat::make('Pages', $totalPages)
                ->description($publishedPages . ' Published pages')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),

            Stat::make('Users', $totalUsers)
                ->description($newUsers . ' New in last 30 days')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}
