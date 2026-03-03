<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Excel to PDF Converter</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 32px 24px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            padding: 40px 36px;
            width: 100%;
            max-width: 560px;
        }

        /* ── Header ── */
        .header {
            text-align: center;
            margin-bottom: 28px;
        }

        .icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4472C4, #2756b0);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .icon svg {
            width: 28px;
            height: 28px;
            fill: white;
        }

        h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #718096;
            font-size: 0.875rem;
        }

        /* ── Error ── */
        .error-box {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 10px;
            padding: 12px 16px;
            color: #c53030;
            font-size: 0.875rem;
            margin-bottom: 20px;
        }

        /* ── Drop zone ── */
        .drop-zone {
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            padding: 32px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #f7fafc;
            position: relative;
        }

        .drop-zone:hover,
        .drop-zone.drag-over {
            border-color: #4472C4;
            background: #ebf0fa;
        }

        .drop-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .drop-zone-icon {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .drop-zone-text {
            color: #4a5568;
            font-size: 0.9rem;
        }

        .drop-zone-text strong {
            color: #4472C4;
        }

        .drop-zone-hint {
            color: #a0aec0;
            font-size: 0.78rem;
            margin-top: 5px;
        }

        /* ── File preview ── */
        .file-preview {
            display: none;
            align-items: center;
            gap: 12px;
            background: #ebf0fa;
            border: 1px solid #c3d0ea;
            border-radius: 10px;
            padding: 12px 14px;
            margin-top: 12px;
        }

        .file-preview.visible {
            display: flex;
        }

        .file-preview-icon {
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .file-preview-info {
            flex: 1;
            overflow: hidden;
        }

        .file-preview-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #2d3748;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-preview-size {
            font-size: 0.75rem;
            color: #718096;
            margin-top: 2px;
        }

        .file-preview-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: #a0aec0;
            font-size: 1.1rem;
            flex-shrink: 0;
            padding: 2px;
        }

        .file-preview-remove:hover {
            color: #e53e3e;
        }

        /* ── Settings panel ── */
        .settings-panel {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: max-height 0.4s ease, opacity 0.3s ease, margin 0.3s ease;
            margin-top: 0;
        }

        .settings-panel.open {
            max-height: 700px;
            opacity: 1;
            margin-top: 20px;
        }

        .settings-title {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #a0aec0;
            margin-bottom: 14px;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .setting-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .setting-group.full {
            grid-column: 1 / -1;
        }

        .setting-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #4a5568;
        }

        .setting-group select,
        .setting-group input[type="text"],
        .setting-group input[type="number"] {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #2d3748;
            background: #f7fafc;
            outline: none;
            transition: border-color 0.2s;
            width: 100%;
        }

        .setting-group select:focus,
        .setting-group input:focus {
            border-color: #4472C4;
            background: #fff;
        }

        /* Toggle switch */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .toggle-label {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .toggle-label small {
            display: block;
            font-size: 0.72rem;
            color: #a0aec0;
            margin-top: 1px;
        }

        .toggle {
            position: relative;
            width: 38px;
            height: 22px;
            flex-shrink: 0;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: #cbd5e0;
            border-radius: 22px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: white;
            left: 3px;
            top: 3px;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .toggle input:checked+.toggle-slider {
            background: #4472C4;
        }

        .toggle input:checked+.toggle-slider::before {
            transform: translateX(16px);
        }

        /* Color theme picker */
        .color-swatches {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 2px;
        }

        .swatch {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid transparent;
            cursor: pointer;
            transition: transform 0.15s, border-color 0.15s;
        }

        .swatch:hover {
            transform: scale(1.15);
        }

        .swatch.active {
            border-color: #1a202c;
            transform: scale(1.1);
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #e8edf4;
            margin: 16px 0;
        }

        /* ── Convert button ── */
        .btn {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 13px;
            background: linear-gradient(135deg, #4472C4, #2756b0);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn:hover {
            opacity: 0.92;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .btn-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .spinner {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .footer-note {
            text-align: center;
            color: #a0aec0;
            font-size: 0.75rem;
            margin-top: 16px;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="header">
            <div class="icon">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8 13h2v2H8v-2zm0-4h8v2H8V9zm0 8h8v2H8v-2z" />
                </svg>
            </div>
            <h1>Excel to PDF</h1>
            <p class="subtitle">Upload your spreadsheet and customise before converting.</p>
        </div>

        @if ($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('excel.convert') }}" enctype="multipart/form-data" id="uploadForm">
            @csrf

            {{-- ── File upload ── --}}
            <div class="drop-zone" id="dropZone">
                <input type="file" name="excel_file" id="fileInput" accept=".xlsx,.xls,.csv" />
                <div class="drop-zone-icon">📊</div>
                <div class="drop-zone-text"><strong>Click to browse</strong> or drag & drop</div>
                <div class="drop-zone-hint">Supports .xlsx, .xls, .csv — max 10 MB</div>
            </div>

            <div class="file-preview" id="filePreview">
                <div class="file-preview-icon">📗</div>
                <div class="file-preview-info">
                    <div class="file-preview-name" id="previewName">—</div>
                    <div class="file-preview-size" id="previewSize">—</div>
                </div>
                <button type="button" class="file-preview-remove" id="removeFile" title="Remove">✕</button>
            </div>

            {{-- ── Settings panel (shown after file chosen) ── --}}
            <div class="settings-panel" id="settingsPanel">

                <div class="settings-title">⚙ PDF Settings</div>

                <div class="settings-grid">

                    {{-- Paper size --}}
                    <div class="setting-group">
                        <label for="paper_size">Paper Size</label>
                        <select name="paper_size" id="paper_size">
                            <option value="a4">A4</option>
                            <option value="letter">Letter (US)</option>
                            <option value="legal">Legal</option>
                            <option value="a3">A3</option>
                        </select>
                    </div>

                    {{-- Orientation --}}
                    <div class="setting-group">
                        <label for="orientation">Orientation</label>
                        <select name="orientation" id="orientation">
                            <option value="auto">Auto (by column count)</option>
                            <option value="portrait">Portrait</option>
                            <option value="landscape">Landscape</option>
                        </select>
                    </div>

                    {{-- Font size --}}
                    <div class="setting-group">
                        <label for="font_size">Font Size (px)</label>
                        <input type="number" name="font_size" id="font_size" value="10" min="6" max="18" />
                    </div>

                    {{-- Sheet selection --}}
                    <div class="setting-group">
                        <label for="sheets_to_include">Sheets to Include</label>
                        <select name="sheets_to_include" id="sheets_to_include">
                            <option value="all">All Sheets</option>
                            <option value="first">First Sheet Only</option>
                        </select>
                    </div>

                    {{-- Custom title --}}
                    <div class="setting-group full">
                        <label for="custom_title">Document Title <span style="color:#a0aec0;font-weight:400">(leave
                                blank to use filename)</span></label>
                        <input type="text" name="custom_title" id="custom_title" placeholder="e.g. Q3 Sales Report" />
                    </div>

                </div>

                <hr class="divider" />

                {{-- Toggles --}}
                <div style="display:flex; flex-direction:column; gap:8px;">

                    <div class="toggle-row">
                        <div class="toggle-label">
                            Striped Rows
                            <small>Alternate row background colours</small>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" name="striped_rows" value="1" checked id="striped_rows" />
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div class="toggle-label">
                            Show Header Row
                            <small>Treat first row as a styled header</small>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" name="header_row" value="1" checked id="header_row" />
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div class="toggle-label">
                            Show Page Numbers
                            <small>Print page number in footer</small>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" name="page_numbers" value="1" checked id="page_numbers" />
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div class="toggle-label">
                            Show Borders
                            <small>Draw cell border lines</small>
                        </div>
                        <label class="toggle">
                            <input type="checkbox" name="show_borders" value="1" checked id="show_borders" />
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                </div>

                <hr class="divider" />

                {{-- Accent colour --}}
                <div class="setting-group full">
                    <label>Accent Colour</label>
                    <div class="color-swatches" id="colorSwatches">
                        <span class="swatch active" data-color="#4472C4" style="background:#4472C4" title="Blue"></span>
                        <span class="swatch" data-color="#2E7D32" style="background:#2E7D32" title="Green"></span>
                        <span class="swatch" data-color="#C62828" style="background:#C62828" title="Red"></span>
                        <span class="swatch" data-color="#6A1B9A" style="background:#6A1B9A" title="Purple"></span>
                        <span class="swatch" data-color="#E65100" style="background:#E65100" title="Orange"></span>
                        <span class="swatch" data-color="#00695C" style="background:#00695C" title="Teal"></span>
                        <span class="swatch" data-color="#37474F" style="background:#37474F" title="Slate"></span>
                        <span class="swatch" data-color="#000000" style="background:#000000" title="Black"></span>
                    </div>
                    <input type="hidden" name="accent_color" id="accent_color" value="#4472C4" />
                </div>

            </div>

            {{-- ── Submit ── --}}
            <button class="btn" type="submit" id="submitBtn" disabled>
                <div class="btn-inner">
                    <div class="spinner" id="spinner"></div>
                    <span id="btnText">Select a file first</span>
                </div>
            </button>
        </form>

        <p class="footer-note">Files are deleted from the server immediately after conversion.</p>
    </div>

    <script>
        const fileInput    = document.getElementById('fileInput');
    const dropZone     = document.getElementById('dropZone');
    const filePreview  = document.getElementById('filePreview');
    const previewName  = document.getElementById('previewName');
    const previewSize  = document.getElementById('previewSize');
    const removeFile   = document.getElementById('removeFile');
    const submitBtn    = document.getElementById('submitBtn');
    const btnText      = document.getElementById('btnText');
    const spinner      = document.getElementById('spinner');
    const form         = document.getElementById('uploadForm');
    const settingsPanel= document.getElementById('settingsPanel');

    function formatBytes(b) {
        if (b < 1024) return b + ' B';
        if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
        return (b/1048576).toFixed(1) + ' MB';
    }

    function showFile(file) {
        previewName.textContent = file.name;
        previewSize.textContent = formatBytes(file.size);
        filePreview.classList.add('visible');
        settingsPanel.classList.add('open');
        submitBtn.disabled = false;
        btnText.textContent = 'Convert to PDF';
    }

    function clearFile() {
        fileInput.value = '';
        filePreview.classList.remove('visible');
        settingsPanel.classList.remove('open');
        submitBtn.disabled = true;
        btnText.textContent = 'Select a file first';
    }

    fileInput.addEventListener('change', () => {
        if (fileInput.files[0]) showFile(fileInput.files[0]);
        else clearFile();
    });

    removeFile.addEventListener('click', clearFile);

    // Drag & drop
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            showFile(file);
        }
    });

    // Colour swatches
    document.querySelectorAll('.swatch').forEach(sw => {
        sw.addEventListener('click', () => {
            document.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
            sw.classList.add('active');
            document.getElementById('accent_color').value = sw.dataset.color;
        });
    });

    // Loading state on submit
    form.addEventListener('submit', () => {
        submitBtn.disabled = true;
        spinner.style.display = 'block';
        btnText.textContent = 'Converting…';
    });
    </script>

</body>

</html>
