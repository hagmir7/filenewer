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

        $title = 'Free Online Tools — PDF, Image, Data & More';
        $description = 'Convert, compress, edit and generate files instantly. 50+ free tools for PDF, images, Word documents, CSV data and more. No sign-up required.';

        return view('tools.index', compact('categories', 'title', 'description'));
    }

    public function show(string $slug)
    {
        $tool = Tool::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedTools = Tool::where('category_id', $tool->category_id)
            ->where('id', '!=', $tool->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        $title = $tool->name;
        $description = $tool->description;

        return view('tools.show', compact('tool', 'relatedTools', 'title', 'description'));
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
