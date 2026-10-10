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
    protected ?string $pollingInterval = '30s'; // <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-square-check">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
  <path d="M9 12l2 2l4 -4" />
</svg> no "static"

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
