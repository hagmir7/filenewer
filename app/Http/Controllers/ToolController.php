<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index()
    {
        $categories = Category::with(['tools' => function ($q) {
            $q->where('is_active', true)
                ->orderBy('order');
        }])->get();

        return view('tools.index', compact('categories'));
    }

    public function show(string $slug)
    {
        $tool = Tool::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Same-category tools, excluding current
        $relatedTools = Tool::where('category_id', $tool->category_id)
            ->where('id', '!=', $tool->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        return view('tools.show', compact('tool', 'relatedTools'));
    }


    public function pdfToWord()
    {
        return view('tools.pdf-to-word');
    }

    public function csvToSql()
    {
        return view('tools.csv-to-sql');
    }

    public function invoiceGenerator()
    {
        return view('tools.invoice-generator');
    }

    public function ImageCompressor()
    {
        return view('tools.image-compressor');
    }

    public function pdfMerge()
    {
        return view('tools.pdf-merge');
    }

    public function csvToJson()
    {
        return view('tools.csv-to-json');
    }
}
