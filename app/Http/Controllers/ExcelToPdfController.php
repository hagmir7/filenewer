<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class ExcelToPdfController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'excel_file'      => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
            'paper_size'      => ['in:a4,letter,legal,a3'],
            'orientation'     => ['in:auto,portrait,landscape'],
            'font_size'       => ['integer', 'min:6', 'max:18'],
            'accent_color'    => ['regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_title'    => ['nullable', 'string', 'max:120'],
            'sheets_to_include' => ['in:all,first'],
        ]);

        $file         = $request->file('excel_file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $file->getClientOriginalExtension();

        // Move to a real OS path (avoids Windows mixed-separator issues)
        $tempDir = storage_path('app' . DIRECTORY_SEPARATOR . 'temp_excel');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        $tempFilename = uniqid('excel_', true) . '.' . $extension;
        $fullPath     = $tempDir . DIRECTORY_SEPARATOR . $tempFilename;
        $file->move($tempDir, $tempFilename);

        // ── Collect settings ──────────────────────────────────────────────
        $settings = [
            'paper_size'       => $request->input('paper_size', 'a4'),
            'orientation'      => $request->input('orientation', 'auto'),
            'font_size'        => (int) $request->input('font_size', 10),
            'accent_color'     => $request->input('accent_color', '#4472C4'),
            'custom_title'     => trim($request->input('custom_title', '')) ?: $originalName,
            'sheets_to_include'=> $request->input('sheets_to_include', 'all'),
            'striped_rows'     => $request->boolean('striped_rows'),
            'header_row'       => $request->boolean('header_row'),
            'page_numbers'     => $request->boolean('page_numbers'),
            'show_borders'     => $request->boolean('show_borders'),
        ];

        try {
            if (!file_exists($fullPath)) {
                throw new \RuntimeException("Uploaded file could not be saved to: {$fullPath}");
            }

            $spreadsheet = IOFactory::load($fullPath);
            $allSheets   = $spreadsheet->getAllSheets();

            // Apply sheet filter
            if ($settings['sheets_to_include'] === 'first') {
                $allSheets = [$spreadsheet->getSheet(0)];
            }

            $sheets = [];
            foreach ($allSheets as $sheet) {
                $rows = $sheet->toArray(null, true, true, false);

                // Strip entirely empty rows
                $rows = array_values(array_filter($rows, fn($row) =>
                    array_filter($row, fn($cell) => $cell !== null && $cell !== '')
                ));

                if (empty($rows)) continue;

                $colWidths = [];
                foreach ($rows as $row) {
                    foreach ($row as $i => $cell) {
                        $colWidths[$i] = max($colWidths[$i] ?? 0, mb_strlen((string) $cell));
                    }
                }

                $sheets[] = [
                    'title'     => $sheet->getTitle(),
                    'rows'      => $rows,
                    'colWidths' => $colWidths,
                ];
            }

            if (empty($sheets)) {
                throw new \RuntimeException('The spreadsheet appears to be empty.');
            }

            // Resolve orientation
            if ($settings['orientation'] === 'auto') {
                $maxCols = max(array_map(fn($s) => count($s['colWidths']), $sheets));
                $settings['orientation'] = $maxCols > 8 ? 'landscape' : 'portrait';
            }

            // Render Blade to HTML string first, then pass to DomPDF.
            // This avoids DomPDF's own view-finder failing on some Laravel setups.
            $html = view('excel_pdf', [
                'sheets'   => $sheets,
                'settings' => $settings,
            ])->render();

            $pdf = Pdf::loadHTML($html)
                ->setPaper($settings['paper_size'], $settings['orientation'])
                ->setOptions([
                    'defaultFont'     => 'DejaVu Sans',
                    'isRemoteEnabled' => false,
                    'dpi'             => 100,
                ]);

            @unlink($fullPath);

            return $pdf->download($originalName . '.pdf');

        } catch (\Exception $e) {
            @unlink($fullPath);
            return back()->withErrors(['excel_file' => 'Could not read the file: ' . $e->getMessage()]);
        }
    }
}
