<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(){
        return view('tools.index');
    }

    public function show($slug)
    {
        $tool = Tool::where('slug', $slug)->firstOrFail();
        return view('tools.show', compact('tool'));
    }


    public function pdfToWord(){
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
