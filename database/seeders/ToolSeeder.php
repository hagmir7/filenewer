<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Tabler outline icon bodies (inner <path> markup), keyed by icon name.
     */
    private const ICONS = [
        'pdf' => '<path d="M10 8v8h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-2" /><path d="M3 12h2a2 2 0 1 0 0 -4h-2v8" /><path d="M17 12h3" /><path d="M21 8h-4v8" />',
        'photo' => '<path d="M15 8h.01" /><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12" /><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" /><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />',
        'file-word' => '<path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" /><path d="M9 12l1.333 5l1.667 -4l1.667 4l1.333 -5" />',
        'chart-bar' => '<path d="M3 13a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v6a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -6" /><path d="M15 9a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -10" /><path d="M9 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v14a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -14" /><path d="M4 20h14" />',
        'brand-adobe-illustrator' => '<path d="M3 12c0 -4.243 0 -6.364 1.318 -7.682s3.44 -1.318 7.682 -1.318s6.364 0 7.682 1.318s1.318 3.44 1.318 7.682s0 6.364 -1.318 7.682s-3.44 1.318 -7.682 1.318s-6.364 0 -7.682 -1.318s-1.318 -3.44 -1.318 -7.682" /><path d="M12.947 15.79l-.82 -2.653m-4.864 2.652l.82 -2.652m0 0l.687 -2.218c.558 -1.806 .838 -2.708 1.335 -2.708c.498 0 .777 .902 1.336 2.708l.686 2.218m-4.043 0h4.043" /><path d="M15.789 15.789v-4.736" /><path d="M15.789 8.684v-.473" />',
        'lock-check' => '<path d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v.5" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /><path d="M15 19l2 2l4 -4" />',
        'device-imac-code' => '<path d="M11.5 17h-7.5a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v9" /><path d="M3 13h18" /><path d="M8 21h3.5" /><path d="M10 17l-.5 4" /><path d="M20 21l2 -2l-2 -2" /><path d="M17 17l-2 2l2 2" />',
        'cut' => '<path d="M4 17a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M14 17a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M9.15 14.85l8.85 -10.85" /><path d="M6 4l8.85 10.85" />',
        'arrows-minimize' => '<path d="M5 9l4 0l0 -4" /><path d="M3 3l6 6" /><path d="M5 15l4 0l0 4" /><path d="M3 21l6 -6" /><path d="M19 9l-4 0l0 -4" /><path d="M15 9l6 -6" /><path d="M19 15l-4 0l0 4" /><path d="M15 15l6 6" />',
        'transform' => '<path d="M3 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3" /><path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3" /><path d="M15 18a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />',
        'lock' => '<path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" />',
        'zoom' => '<path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" />',
        'rotate' => '<path d="M19.95 11a8 8 0 1 0 -.5 4m.5 5v-5h-5" />',
        'badge-tm' => '<path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M6 9h4" /><path d="M8 9v6" /><path d="M13 15v-6l2 3l2 -3v6" />',
        'text-resize' => '<path d="M3 5a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 5a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M3 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 7v10" /><path d="M7 5h10" /><path d="M7 19h10" /><path d="M19 7v10" /><path d="M10 10h4" /><path d="M12 14v-4" />',

        // Replacements for former emojis
        'file-text' => '<path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" />',
        'file-description' => '<path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" /><path d="M9 17h6" /><path d="M9 13h6" />',
        'file-spreadsheet' => '<path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" /><path d="M8 11h8v7h-8l0 -7" /><path d="M8 15h8" /><path d="M11 11v7" />',
        'file-invoice' => '<path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M19 12v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-14a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M9 7h1" /><path d="M9 11h6" /><path d="M9 15h6" />',
        'file-certificate' => '<path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 8v-3a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M6 14m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M4.5 17l-1.5 5l3 -1.5l3 1.5l-1.5 -5" />',
        'paperclip' => '<path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" />',
        'droplet' => '<path d="M7.502 19.423c2.602 2.105 6.395 2.105 8.996 0c2.602 -2.105 3.262 -5.708 1.566 -8.546l-4.89 -7.26c-.42 -.625 -1.287 -.803 -1.936 -.397a1.376 1.376 0 0 0 -.41 .397l-4.893 7.26c-1.695 2.838 -1.035 6.441 1.567 8.546" />',
        'mail' => '<path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" />',
        'arrows-exchange' => '<path d="M7 10h14l-4 -4" /><path d="M17 14h-14l4 4" />',
        'table' => '<path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14" /><path d="M3 10h18" /><path d="M10 3v18" />',
        'palette' => '<path d="M12 21a9 9 0 0 1 0 -18c4.97 0 9 3.582 9 8c0 1.06 -.474 2.078 -1.318 2.828c-.844 .75 -1.989 1.172 -3.182 1.172h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25" /><path d="M8.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M16.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
        'sparkles' => '<path d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2m0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2m-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6" />',
        'key' => '<path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0" /><path d="M15 9h.01" />',
        'hash' => '<path d="M5 9l14 0" /><path d="M5 15l14 0" /><path d="M11 4l-4 16" /><path d="M17 4l-4 16" />',
        'braces' => '<path d="M7 4a2 2 0 0 0 -2 2v3a2 3 0 0 1 -2 3a2 3 0 0 1 2 3v3a2 2 0 0 0 2 2" /><path d="M17 4a2 2 0 0 1 2 2v3a2 3 0 0 0 2 3a2 3 0 0 0 -2 3v3a2 2 0 0 1 -2 2" />',
        'id' => '<path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" /><path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M15 8l2 0" /><path d="M15 12l2 0" /><path d="M7 16l10 0" />',
        'clock' => '<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" />',
    ];

    /**
     * Build a Tabler outline SVG by icon name.
     */
    private function icon(string $name): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-' . $name . '">'
            . '<path stroke="none" d="M0 0h24v24H0z" fill="none" />'
            . self::ICONS[$name]
            . '</svg>';
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =========================
        // CATEGORIES
        // =========================
        $categories = [
            'pdf-tools' => [
                'title' => 'PDF Tools',
                'icon' => $this->icon('pdf'),
                'description' => 'Convert, edit, compress and manage PDF files.',
            ],
            'image-tools' => [
                'title' => 'Image Tools',
                'icon' => $this->icon('photo'),
                'description' => 'Edit, convert and optimize images.',
            ],
            'word-tools' => [
                'title' => 'Word & Document Tools',
                'icon' => $this->icon('file-word'),
                'description' => 'Work with Word and document files.',
            ],
            'document-generators' => [
                'title' => 'Document Generators',
                'icon' => $this->icon('file-text'),
                'description' => 'Generate documents like invoices and resumes.',
            ],
            'data-tools' => [
                'title' => 'Data & CSV Tools',
                'icon' => $this->icon('chart-bar'),
                'description' => 'Handle CSV, JSON and structured data.',
            ],
            'ai-tools' => [
                'title' => 'AI Tools',
                'icon' => $this->icon('brand-adobe-illustrator'),
                'description' => 'AI-powered productivity tools.',
            ],
            'security-tools' => [
                'title' => 'Security Tools',
                'icon' => $this->icon('lock-check'),
                'description' => 'Protect and secure your files.',
            ],
            'dev-tools' => [
                'title' => 'Developer Tools',
                'icon' => $this->icon('device-imac-code'),
                'description' => 'Utilities for developers.',
            ],
        ];

        $categoryIds = [];

        foreach ($categories as $slug => $cat) {
            $category = Category::updateOrCreate(
                ['slug' => $slug],
                array_merge($cat, ['slug' => $slug])
            );
            $categoryIds[$slug] = $category->id;
        }

        // =========================
        // TOOLS
        // [name, slug, description, icon, category, title]
        // =========================
        $tools = [

            // PDF Tools
            ['PDF to Word', 'pdf-to-word', 'Convert PDF to DOCX.', $this->icon('pdf'), 'pdf-tools', 'PDF to Word Converter – Free Online PDF to DOCX'],
            ['PDF to Excel', 'pdf-to-excel', 'Convert PDF to XLSX.', $this->icon('file-spreadsheet'), 'pdf-tools', 'PDF to Excel Converter – Export PDF Tables to XLSX'],
            ['PDF to JPG', 'pdf-to-jpg', 'Convert PDF to images.', $this->icon('photo'), 'pdf-tools', 'PDF to JPG Converter – Convert PDF Pages to Images'],
            ['Word to PDF', 'word-to-pdf', 'Convert DOCX to PDF.', $this->icon('file-word'), 'pdf-tools', 'Word to PDF Converter – Convert DOCX to PDF Online'],
            ['Merge PDF', 'merge-pdf', 'Combine PDFs.', $this->icon('paperclip'), 'pdf-tools', 'Merge PDF Files – Combine Multiple PDFs into One'],
            ['Split PDF', 'split-pdf', 'Split PDF pages.', $this->icon('cut'), 'pdf-tools', 'Split PDF – Extract & Separate PDF Pages Online'],
            ['Compress PDF', 'compress-pdf', 'Reduce PDF size.', $this->icon('arrows-minimize'), 'pdf-tools', 'Compress PDF – Reduce PDF File Size Online Free'],
            ['PDF to PNG', 'pdf-to-png', 'Convert PDF to PNG.', $this->icon('transform'), 'pdf-tools', 'PDF to PNG Converter – Convert PDF to PNG Images'],
            ['Encrypt PDF', 'encrypt-pdf', 'Protect PDF with password.', $this->icon('lock'), 'pdf-tools', 'Encrypt PDF – Password Protect Your PDF File'],
            ['OCR PDF', 'ocr-pdf', 'Extract text from PDF.', $this->icon('zoom'), 'pdf-tools', 'OCR PDF – Extract Text from Scanned PDF Online'],
            ['Rotate PDF', 'rotate-pdf', 'Rotate PDF pages.', $this->icon('rotate'), 'pdf-tools', 'Rotate PDF – Rotate PDF Pages Online for Free'],
            ['Watermark PDF', 'watermark-pdf', 'Add watermark to PDF.', $this->icon('badge-tm'), 'pdf-tools', 'Watermark PDF – Add Text or Image Watermark to PDF'],

            // Image Tools
            ['Compress Image', 'compress-image', 'Reduce image size.', $this->icon('arrows-minimize'), 'image-tools', 'Compress Image – Reduce Image File Size Online Free'],
            ['Image to JPG', 'image-to-jpg', 'Convert to JPG.', $this->icon('photo'), 'image-tools', 'Image to JPG Converter – Convert PNG, WebP to JPG'],
            ['Image to PNG', 'image-to-png', 'Convert to PNG.', $this->icon('transform'), 'image-tools', 'Image to PNG Converter – Convert JPG, WebP to PNG'],
            ['Resize Image', 'resize-image', 'Resize images.', $this->icon('text-resize'), 'image-tools', 'Resize Image – Change Image Dimensions Online Free'],
            ['Crop Image', 'crop-image', 'Crop images.', $this->icon('cut'), 'image-tools', 'Crop Image – Crop & Trim Images Online for Free'],
            ['Watermark Image', 'watermark-image', 'Add watermark.', $this->icon('badge-tm'), 'image-tools', 'Watermark Image – Add Watermark to Photos Online'],
            ['Image Converter', 'image-converter', 'Convert formats.', $this->icon('rotate'), 'image-tools', 'Image Converter – Convert Images Between Any Format'],
            ['Blur Image', 'blur-image', 'Blur parts of image.', $this->icon('droplet'), 'image-tools', 'Blur Image – Blur Faces or Areas in Photos Online'],

            // Word Tools
            ['Word to JPG', 'word-to-jpg', 'Convert Word to images.', $this->icon('file-word'), 'word-tools', 'Word to JPG Converter – Convert DOCX Pages to Images'],
            ['Word to TXT', 'word-to-txt', 'Extract text.', $this->icon('file-text'), 'word-tools', 'Word to TXT – Extract Plain Text from Word Documents'],
            ['Text to Word', 'text-to-word', 'Convert text to DOCX.', $this->icon('file-description'), 'word-tools', 'Text to Word Converter – Convert TXT to DOCX Online'],
            ['Merge DOCX', 'merge-docx', 'Merge Word files.', $this->icon('paperclip'), 'word-tools', 'Merge Word Documents – Combine Multiple DOCX Files'],
            ['Split DOCX', 'split-docx', 'Split Word files.', $this->icon('cut'), 'word-tools', 'Split Word Document – Separate DOCX into Multiple Files'],

            // Generators
            ['Invoice Generator', 'invoice-generator', 'Create invoices.', $this->icon('file-invoice'), 'document-generators', 'Invoice Generator – Create & Download Free PDF Invoices'],
            ['Resume Builder', 'resume-builder', 'Build CV بسهولة.', $this->icon('file-word'), 'document-generators', 'Resume Builder – Create a Professional CV Online Free'],
            ['Cover Letter Generator', 'cover-letter', 'Generate cover letters.', $this->icon('mail'), 'document-generators', 'Cover Letter Generator – Write a Cover Letter Online'],
            ['Contract Generator', 'contract-generator', 'Create contracts.', $this->icon('file-certificate'), 'document-generators', 'Contract Generator – Create Legal Contracts Online'],

            // Data Tools
            ['CSV to JSON', 'csv-to-json', 'Convert CSV to JSON.', $this->icon('arrows-exchange'), 'data-tools', 'CSV to JSON Converter – Convert CSV Data to JSON Online'],
            ['JSON to CSV', 'json-to-csv', 'Convert JSON to CSV.', $this->icon('arrows-exchange'), 'data-tools', 'JSON to CSV Converter – Export JSON as CSV Online'],
            ['CSV Viewer', 'csv-viewer', 'View CSV files.', $this->icon('chart-bar'), 'data-tools', 'CSV Viewer – Open & View CSV Files Online for Free'],
            ['Excel to CSV', 'excel-to-csv', 'Convert Excel to CSV.', $this->icon('table'), 'data-tools', 'Excel to CSV Converter – Convert XLSX to CSV Online'],

            // AI Tools
            ['AI Text Generator', 'ai-text', 'Generate text with AI.', $this->icon('brand-adobe-illustrator'), 'ai-tools', 'AI Text Generator – Generate Content with Artificial Intelligence'],
            ['AI Image Generator', 'ai-image', 'Generate images.', $this->icon('palette'), 'ai-tools', 'AI Image Generator – Create Images from Text with AI'],
            ['AI PDF Summary', 'ai-pdf-summary', 'Summarize PDFs.', $this->icon('sparkles'), 'ai-tools', 'AI PDF Summarizer – Summarize PDF Documents Instantly'],

            // Security
            ['File Encryptor', 'file-encryptor', 'Encrypt files.', $this->icon('lock-check'), 'security-tools', 'File Encryptor – Encrypt & Secure Your Files Online'],
            ['Password Generator', 'password-generator', 'Generate strong passwords.', $this->icon('key'), 'security-tools', 'Password Generator – Generate Strong Secure Passwords'],
            ['Hash Generator', 'hash-generator', 'Generate hashes.', $this->icon('hash'), 'security-tools', 'Hash Generator – Generate MD5, SHA256 & More Online'],

            // Dev Tools
            ['JSON Formatter', 'json-formatter', 'Format JSON.', $this->icon('braces'), 'dev-tools', 'JSON Formatter – Beautify & Validate JSON Online Free'],
            ['Base64 Encoder', 'base64-encoder', 'Encode Base64.', $this->icon('lock-check'), 'dev-tools', 'Base64 Encoder & Decoder – Encode or Decode Base64'],
            ['UUID Generator', 'uuid-generator', 'Generate UUIDs.', $this->icon('id'), 'dev-tools', 'UUID Generator – Generate Random UUIDs Online Free'],
            ['Timestamp Converter', 'timestamp', 'Convert timestamps.', $this->icon('clock'), 'dev-tools', 'Timestamp Converter – Convert Unix Timestamps Online'],
        ];

        $order = 1;

        foreach ($tools as $row) {
            $tool = Tool::where('slug', $row[1])->first();

            if ($tool) {
                $tool->update([
                    // 'name'        => $row[0],
                    // 'slug'        => $row[1],
                    // 'description' => $row[2],
                    'icon'        => $row[3],
                    // 'is_active'   => true,
                    // 'order'       => $order++,
                    // 'category_id' => $categoryIds[$row[4]],
                    // 'title'       => $row[5],
                ]);
            }
        }
    }
}
