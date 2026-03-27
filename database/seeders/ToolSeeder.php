<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
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
                'icon' => '📕',
                'description' => 'Convert, edit, compress and manage PDF files.',
            ],
            'image-tools' => [
                'title' => 'Image Tools',
                'icon' => '🖼️',
                'description' => 'Edit, convert and optimize images.',
            ],
            'word-tools' => [
                'title' => 'Word & Document Tools',
                'icon' => '📄',
                'description' => 'Work with Word and document files.',
            ],
            'document-generators' => [
                'title' => 'Document Generators',
                'icon' => '📝',
                'description' => 'Generate documents like invoices and resumes.',
            ],
            'data-tools' => [
                'title' => 'Data & CSV Tools',
                'icon' => '📊',
                'description' => 'Handle CSV, JSON and structured data.',
            ],
            'ai-tools' => [
                'title' => 'AI Tools',
                'icon' => '🤖',
                'description' => 'AI-powered productivity tools.',
            ],
            'security-tools' => [
                'title' => 'Security Tools',
                'icon' => '🔐',
                'description' => 'Protect and secure your files.',
            ],
            'dev-tools' => [
                'title' => 'Developer Tools',
                'icon' => '💻',
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
        // =========================
        $tools = [

            // PDF Tools
            ['PDF to Word', 'pdf-to-word', 'Convert PDF to DOCX.', '📕', 'pdf-tools', 'PDF to Word Converter – Free Online PDF to DOCX'],
            ['PDF to Excel', 'pdf-to-excel', 'Convert PDF to XLSX.', '📗', 'pdf-tools', 'PDF to Excel Converter – Export PDF Tables to XLSX'],
            ['PDF to JPG', 'pdf-to-jpg', 'Convert PDF to images.', '🖼️', 'pdf-tools', 'PDF to JPG Converter – Convert PDF Pages to Images'],
            ['Word to PDF', 'word-to-pdf', 'Convert DOCX to PDF.', '📄', 'pdf-tools', 'Word to PDF Converter – Convert DOCX to PDF Online'],
            ['Merge PDF', 'merge-pdf', 'Combine PDFs.', '📎', 'pdf-tools', 'Merge PDF Files – Combine Multiple PDFs into One'],
            ['Split PDF', 'split-pdf', 'Split PDF pages.', '✂️', 'pdf-tools', 'Split PDF – Extract & Separate PDF Pages Online'],
            ['Compress PDF', 'compress-pdf', 'Reduce PDF size.', '🗜️', 'pdf-tools', 'Compress PDF – Reduce PDF File Size Online Free'],
            ['PDF to PNG', 'pdf-to-png', 'Convert PDF to PNG.', '🟥', 'pdf-tools', 'PDF to PNG Converter – Convert PDF to PNG Images'],
            ['Encrypt PDF', 'encrypt-pdf', 'Protect PDF with password.', '🔒', 'pdf-tools', 'Encrypt PDF – Password Protect Your PDF File'],
            ['OCR PDF', 'ocr-pdf', 'Extract text from PDF.', '🔍', 'pdf-tools', 'OCR PDF – Extract Text from Scanned PDF Online'],
            ['Rotate PDF', 'rotate-pdf', 'Rotate PDF pages.', '🔄', 'pdf-tools', 'Rotate PDF – Rotate PDF Pages Online for Free'],
            ['Watermark PDF', 'watermark-pdf', 'Add watermark to PDF.', '💧', 'pdf-tools', 'Watermark PDF – Add Text or Image Watermark to PDF'],

            // Image Tools
            ['Compress Image', 'compress-image', 'Reduce image size.', '🗜️', 'image-tools', 'Compress Image – Reduce Image File Size Online Free'],
            ['Image to JPG', 'image-to-jpg', 'Convert to JPG.', '🖼️', 'image-tools', 'Image to JPG Converter – Convert PNG, WebP to JPG'],
            ['Image to PNG', 'image-to-png', 'Convert to PNG.', '🟥', 'image-tools', 'Image to PNG Converter – Convert JPG, WebP to PNG'],
            ['Resize Image', 'resize-image', 'Resize images.', '📏', 'image-tools', 'Resize Image – Change Image Dimensions Online Free'],
            ['Crop Image', 'crop-image', 'Crop images.', '✂️', 'image-tools', 'Crop Image – Crop & Trim Images Online for Free'],
            ['Watermark Image', 'watermark-image', 'Add watermark.', '💧', 'image-tools', 'Watermark Image – Add Watermark to Photos Online'],
            ['Image Converter', 'image-converter', 'Convert formats.', '🔄', 'image-tools', 'Image Converter – Convert Images Between Any Format'],
            ['Blur Image', 'blur-image', 'Blur parts of image.', '🌫️', 'image-tools', 'Blur Image – Blur Faces or Areas in Photos Online'],

            // Word Tools
            ['Word to JPG', 'word-to-jpg', 'Convert Word to images.', '📄', 'word-tools', 'Word to JPG Converter – Convert DOCX Pages to Images'],
            ['Word to TXT', 'word-to-txt', 'Extract text.', '📝', 'word-tools', 'Word to TXT – Extract Plain Text from Word Documents'],
            ['Text to Word', 'text-to-word', 'Convert text to DOCX.', '📃', 'word-tools', 'Text to Word Converter – Convert TXT to DOCX Online'],
            ['Merge DOCX', 'merge-docx', 'Merge Word files.', '📎', 'word-tools', 'Merge Word Documents – Combine Multiple DOCX Files'],
            ['Split DOCX', 'split-docx', 'Split Word files.', '✂️', 'word-tools', 'Split Word Document – Separate DOCX into Multiple Files'],

            // Generators
            ['Invoice Generator', 'invoice-generator', 'Create invoices.', '💵', 'document-generators', 'Invoice Generator – Create & Download Free PDF Invoices'],
            ['Resume Builder', 'resume-builder', 'Build CV بسهولة.', '📄', 'document-generators', 'Resume Builder – Create a Professional CV Online Free'],
            ['Cover Letter Generator', 'cover-letter', 'Generate cover letters.', '✉️', 'document-generators', 'Cover Letter Generator – Write a Cover Letter Online'],
            ['Contract Generator', 'contract-generator', 'Create contracts.', '📜', 'document-generators', 'Contract Generator – Create Legal Contracts Online'],

            // Data Tools
            ['CSV to JSON', 'csv-to-json', 'Convert CSV to JSON.', '🔁', 'data-tools', 'CSV to JSON Converter – Convert CSV Data to JSON Online'],
            ['JSON to CSV', 'json-to-csv', 'Convert JSON to CSV.', '🔁', 'data-tools', 'JSON to CSV Converter – Export JSON as CSV Online'],
            ['CSV Viewer', 'csv-viewer', 'View CSV files.', '📊', 'data-tools', 'CSV Viewer – Open & View CSV Files Online for Free'],
            ['Excel to CSV', 'excel-to-csv', 'Convert Excel to CSV.', '📉', 'data-tools', 'Excel to CSV Converter – Convert XLSX to CSV Online'],

            // AI Tools
            ['AI Text Generator', 'ai-text', 'Generate text with AI.', '🤖', 'ai-tools', 'AI Text Generator – Generate Content with Artificial Intelligence'],
            ['AI Image Generator', 'ai-image', 'Generate images.', '🎨', 'ai-tools', 'AI Image Generator – Create Images from Text with AI'],
            ['AI PDF Summary', 'ai-pdf-summary', 'Summarize PDFs.', '🧠', 'ai-tools', 'AI PDF Summarizer – Summarize PDF Documents Instantly'],

            // Security
            ['File Encryptor', 'file-encryptor', 'Encrypt files.', '🔐', 'security-tools', 'File Encryptor – Encrypt & Secure Your Files Online'],
            ['Password Generator', 'password-generator', 'Generate strong passwords.', '🔑', 'security-tools', 'Password Generator – Generate Strong Secure Passwords'],
            ['Hash Generator', 'hash-generator', 'Generate hashes.', '#️⃣', 'security-tools', 'Hash Generator – Generate MD5, SHA256 & More Online'],

            // Dev Tools
            ['JSON Formatter', 'json-formatter', 'Format JSON.', '🧩', 'dev-tools', 'JSON Formatter – Beautify & Validate JSON Online Free'],
            ['Base64 Encoder', 'base64-encoder', 'Encode Base64.', '🔐', 'dev-tools', 'Base64 Encoder & Decoder – Encode or Decode Base64'],
            ['UUID Generator', 'uuid-generator', 'Generate UUIDs.', '🆔', 'dev-tools', 'UUID Generator – Generate Random UUIDs Online Free'],
            ['Timestamp Converter', 'timestamp', 'Convert timestamps.', '⏱️', 'dev-tools', 'Timestamp Converter – Convert Unix Timestamps Online'],
        ];

        $order = 1;

        foreach ($tools as $tool) {
            Tool::updateOrCreate(
                ['slug' => $tool[1]],
                [
                    'name'        => $tool[0],
                    'slug'        => $tool[1],
                    'description' => $tool[2],
                    'icon'        => $tool[3],
                    'is_active'   => true,
                    'order'       => $order++,
                    'category_id' => $categoryIds[$tool[4]],
                    'title'   => $tool[5],
                ]
            );
        }
    }
}
