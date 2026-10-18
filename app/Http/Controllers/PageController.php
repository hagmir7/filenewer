<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $title = $page->title;

        return view('page.show', compact('page', 'title'));
    }


    public function index()
    {
        $pages = Page::all();

        $title = "All Pages | Filenewer";
        $description = "Browse all Filenewer pages: guides, policies and resources about our online file conversion and processing tools.";

        return view('page.index', compact('pages', 'title', 'description'));
    }
}
