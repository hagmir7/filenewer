<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Page;
use App\Models\Tool;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0))
            ->add(Url::create('/about'))
            ->add(Url::create('/contact'));

        Page::where('is_published', 1)->each(function ($page) use ($sitemap) {
            $sitemap->add(
                Url::create("/pages/{$page->slug}")
                    ->setLastModificationDate($page->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });


        Blog::where('is_published', 1)->each(function ($blog) use ($sitemap) {
            $sitemap->add(
                Url::create("/blog/{$blog->slug}")
                    ->setLastModificationDate($blog->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });


        Tool::where('is_active', 1)->each(function ($tool) use ($sitemap) {
            $sitemap->add(
                Url::create("/tools/{$tool->slug}")
                    ->setLastModificationDate($tool->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        return $sitemap->toResponse(request());
    }
}
