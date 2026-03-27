<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('is_published', true)
            ->latest('published_at')
            ->paginate(10);

        return view('blog.index', [
            'blogs' => $blogs,
            'title' => 'Blog - Filenewer',
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $recommended = Blog::where('is_published', true)
            ->where('id', '!=', $blog->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $description = $blog->excerpt;
        $image = $blog->featured_image;
        $title = $blog->title;

        return view('blog.show', compact('blog', 'title', 'description', 'image', 'recommended'));
    }

}
