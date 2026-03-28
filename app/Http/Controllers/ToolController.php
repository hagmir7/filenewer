<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with(['tools' => function ($q) {
            $q->where('is_active', true)
                ->orderBy('order');
        }]);

        if ($request->category) {
            $categories->where('slug', $request->category);
        }

        // ✅ FIX: assign the result
        $categories = $categories->get();

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

        $title = $tool->title;
        $description = $tool->description;
        $tags = $tool->tags;

        return view('tools.show', compact('tool', 'relatedTools', 'title', 'description', 'tags'));
    }

    public function pdfToWord()
    {
        $title = 'Convert PDF to Word Online Free';
        $description = 'Convert PDF files to editable Word documents online for free. No registration required. Fast, secure, and high-quality conversion.';
        return view('tools.pdf-to-word', compact('title', 'description'));
    }

    public function csvToSql()
    {
        $title = 'CSV to SQL Converter Online';
        $description = 'Convert CSV files into SQL INSERT statements instantly. Free, fast, and easy-to-use CSV to SQL converter for developers and analysts.';

        return view('tools.csv-to-sql', compact('title', 'description'));
    }

    public function invoiceGenerator()
    {
        $title = 'Free Invoice Generator';
        $description = 'Create, customize, and download professional invoices online for free. Simple, fast, and perfect for freelancers and businesses.';

        return view('tools.invoice-generator', compact('title', 'description'));
    }

    public function ImageCompressor()
    {
        $title = 'Compress Images Online Free';
        $description = 'Compress JPG, PNG, and WebP images online for free. Reduce file size without losing quality and improve website performance.';

        return view('tools.image-compressor', compact('title', 'description'));
    }

    public function pdfMerge()
    {
        $title = 'Merge PDF Files Online Free';
        $description = 'Merge multiple PDF files into one document online for free. Fast, secure, and easy-to-use PDF merger tool.';

        return view('tools.pdf-merge', compact('title', 'description'));
    }

    public function csvToJson()
    {
        $title = 'CSV to JSON Converter Online';
        $description = 'Convert CSV data to JSON format instantly. Free, fast, and accurate CSV to JSON converter for developers and data processing.';

        return view('tools.csv-to-json', compact('title', 'description'));
    }


}
