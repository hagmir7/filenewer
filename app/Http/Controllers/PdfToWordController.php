<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PdfToWordController extends Controller
{
    // ──────────────────────────────────────────
    // GET /tools/pdf-to-word
    // ──────────────────────────────────────────
    public function index()
    {
        return view('tools.pdf-to-word');
    }

    // ──────────────────────────────────────────
    // POST /tools/pdf-to-word/convert
    // ──────────────────────────────────────────
    public function convert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pdf'        => ['required', 'file', 'max:51200'], // remove mimetypes check
            'format'     => ['nullable', 'in:docx,doc,odt,rtf'],
            'enable_ocr' => ['nullable', 'in:0,1'],
            'ocr_lang'   => ['nullable', 'string', 'max:10'],
        ]);

        $file      = $request->file('pdf');
        $format    = $request->input('format', 'docx');
        $enableOcr = $request->input('enable_ocr') === '1';
        $ocrLang   = $request->input('ocr_lang', 'eng');

        // Create a temp working directory for this conversion
        $id        = Str::uuid();
        $workDir   = storage_path("app/conversions/{$id}");
        $inputPath = "{$workDir}/input.pdf";
        $outputPath = "{$workDir}/output.{$format}";

        @mkdir($workDir, 0755, true);
        $file->move($workDir, 'input.pdf');

        // Optional: OCR pre-processing for scanned PDFs (requires ocrmypdf)
        if ($enableOcr) {
            $ocrOut = "{$workDir}/ocr.pdf";
            exec(sprintf(
                'ocrmypdf --language %s %s %s 2>&1',
                escapeshellarg($ocrLang),
                escapeshellarg($inputPath),
                escapeshellarg($ocrOut)
            ));
            if (file_exists($ocrOut)) {
                $inputPath = $ocrOut;
            }
        }

        // Convert with LibreOffice (requires: sudo apt install libreoffice)
        exec(sprintf(
            'soffice --headless --infilter="writer_pdf_import" --convert-to %s --outdir %s %s 2>&1',
            escapeshellarg($format),
            escapeshellarg($workDir),
            escapeshellarg($inputPath)
        ));

        // LibreOffice names the output after the input file
        $libreOutput = "{$workDir}/input.{$format}";
        if (file_exists($libreOutput)) {
            rename($libreOutput, $outputPath);
        }

        // Check conversion succeeded
        if (! file_exists($outputPath) || filesize($outputPath) === 0) {
            $this->cleanDir($workDir);
            return response()->json([
                'success' => false,
                'message' => 'Conversion failed. Please check your PDF and try again.',
            ], 422);
        }

        // Save info to session so download route can access it
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        session(["conv_{$id}" => [
            'path'   => $outputPath,
            'name'   => $originalName . '.' . $format,
            'size'   => filesize($outputPath),
            'format' => $format,
        ]]);

        return response()->json([
            'success'      => true,
            'download_url' => route('tools.pdf-to-word.download', $id),
            'file_size'    => filesize($outputPath),
        ]);
    }

    // ──────────────────────────────────────────
    // GET /tools/pdf-to-word/download/{id}
    // ──────────────────────────────────────────
    public function download(string $id)
    {
        $data = session("conv_{$id}");

        abort_if(! $data || ! file_exists($data['path']), 404, 'File not found or expired.');

        $mimes = [
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'doc'  => 'application/msword',
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'rtf'  => 'application/rtf',
        ];

        // Stream download — Laravel deletes the file automatically after sending
        return response()->download(
            $data['path'],
            $data['name'],
            ['Content-Type' => $mimes[$data['format']] ?? 'application/octet-stream']
        )->deleteFileAfterSend(true);
    }

    private function cleanDir(string $dir): void
    {
        if (is_dir($dir)) {
            array_map('unlink', glob("{$dir}/*"));
            rmdir($dir);
        }
    }
}
