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
            ['PDF to Word', 'pdf-to-word', 'Convert PDF to DOCX.', '📕', 'pdf-tools'],
            ['PDF to Excel', 'pdf-to-excel', 'Convert PDF to XLSX.', '📗', 'pdf-tools'],
            ['PDF to JPG', 'pdf-to-jpg', 'Convert PDF to images.', '🖼️', 'pdf-tools'],
            ['Word to PDF', 'word-to-pdf', 'Convert DOCX to PDF.', '📄', 'pdf-tools'],
            ['Merge PDF', 'merge-pdf', 'Combine PDFs.', '📎', 'pdf-tools'],
            ['Split PDF', 'split-pdf', 'Split PDF pages.', '✂️', 'pdf-tools'],
            ['Compress PDF', 'compress-pdf', 'Reduce PDF size.', '🗜️', 'pdf-tools'],
            ['PDF to PNG', 'pdf-to-png', 'Convert PDF to PNG.', '🟥', 'pdf-tools'],
            ['Encrypt PDF', 'encrypt-pdf', 'Protect PDF with password.', '🔒', 'pdf-tools'],
            ['OCR PDF', 'ocr-pdf', 'Extract text from PDF.', '🔍', 'pdf-tools'],
            ['Rotate PDF', 'rotate-pdf', 'Rotate PDF pages.', '🔄', 'pdf-tools'],
            ['Watermark PDF', 'watermark-pdf', 'Add watermark to PDF.', '💧', 'pdf-tools'],

            // Image Tools
            ['Compress Image', 'compress-image', 'Reduce image size.', '🗜️', 'image-tools'],
            ['Image to JPG', 'image-to-jpg', 'Convert to JPG.', '🖼️', 'image-tools'],
            ['Image to PNG', 'image-to-png', 'Convert to PNG.', '🟥', 'image-tools'],
            ['Resize Image', 'resize-image', 'Resize images.', '📏', 'image-tools'],
            ['Crop Image', 'crop-image', 'Crop images.', '✂️', 'image-tools'],
            ['Watermark Image', 'watermark-image', 'Add watermark.', '💧', 'image-tools'],
            ['Image Converter', 'image-converter', 'Convert formats.', '🔄', 'image-tools'],
            ['Blur Image', 'blur-image', 'Blur parts of image.', '🌫️', 'image-tools'],

            // Word Tools
            ['Word to JPG', 'word-to-jpg', 'Convert Word to images.', '📄', 'word-tools'],
            ['Word to TXT', 'word-to-txt', 'Extract text.', '📝', 'word-tools'],
            ['Text to Word', 'text-to-word', 'Convert text to DOCX.', '📃', 'word-tools'],
            ['Merge DOCX', 'merge-docx', 'Merge Word files.', '📎', 'word-tools'],
            ['Split DOCX', 'split-docx', 'Split Word files.', '✂️', 'word-tools'],

            // Generators
            ['Invoice Generator', 'invoice-generator', 'Create invoices.', '💵', 'document-generators'],
            ['Resume Builder', 'resume-builder', 'Build CV بسهولة.', '📄', 'document-generators'],
            ['Cover Letter Generator', 'cover-letter', 'Generate cover letters.', '✉️', 'document-generators'],
            ['Contract Generator', 'contract-generator', 'Create contracts.', '📜', 'document-generators'],

            // Data Tools
            ['CSV to JSON', 'csv-to-json', 'Convert CSV to JSON.', '🔁', 'data-tools'],
            ['JSON to CSV', 'json-to-csv', 'Convert JSON to CSV.', '🔁', 'data-tools'],
            ['CSV Viewer', 'csv-viewer', 'View CSV files.', '📊', 'data-tools'],
            ['Excel to CSV', 'excel-to-csv', 'Convert Excel to CSV.', '📉', 'data-tools'],

            // AI Tools
            ['AI Text Generator', 'ai-text', 'Generate text with AI.', '🤖', 'ai-tools'],
            ['AI Image Generator', 'ai-image', 'Generate images.', '🎨', 'ai-tools'],
            ['AI PDF Summary', 'ai-pdf-summary', 'Summarize PDFs.', '🧠', 'ai-tools'],

            // Security
            ['File Encryptor', 'file-encryptor', 'Encrypt files.', '🔐', 'security-tools'],
            ['Password Generator', 'password-generator', 'Generate strong passwords.', '🔑', 'security-tools'],
            ['Hash Generator', 'hash-generator', 'Generate hashes.', '#️⃣', 'security-tools'],

            // Dev Tools
            ['JSON Formatter', 'json-formatter', 'Format JSON.', '🧩', 'dev-tools'],
            ['Base64 Encoder', 'base64-encoder', 'Encode Base64.', '🔐', 'dev-tools'],
            ['UUID Generator', 'uuid-generator', 'Generate UUIDs.', '🆔', 'dev-tools'],
            ['Timestamp Converter', 'timestamp', 'Convert timestamps.', '⏱️', 'dev-tools'],
        ];

        $order = 1;

        foreach ($tools as $tool) {
            Tool::updateOrCreate(
                ['slug' => $tool[1]],
                [
                    'name' => $tool[0],
                    'slug' => $tool[1],
                    'description' => $tool[2],
                    'icon' => $tool[3],
                    'is_active' => true,
                    'order' => $order++,
                    'category_id' => $categoryIds[$tool[4]],
                ]
            );
        }
    }
}
