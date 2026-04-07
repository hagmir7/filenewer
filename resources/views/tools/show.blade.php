@extends('layouts.base')
@push('scripts')
<x-ld-json :tool="$tool" />
@endpush
@section('content')

{{-- ══ TOOL HERO ══ --}}
<section class="relative pt-12 pb-8 overflow-hidden hero-glow">
    <div class="absolute inset-0 grid-lines pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-6 relative z-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-fn-text3 mb-6">
            <a href="/" class="hover:text-fn-text transition-colors">Home</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <a href="/tools" class="hover:text-fn-text transition-colors">Tools</a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <a href="/tools?category={{ $tool->category->slug }}" class="hover:text-fn-text transition-colors">
                {{ $tool->category->title }}
            </a>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6" />
            </svg>
            <span class="text-fn-text2">{{ $tool->name }}</span>
        </nav>

        {{-- Tool heading --}}
        <div class="flex items-start gap-5 mb-6">
            <div
                class="w-14 h-14 rounded-2xl bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-3xl shrink-0">
                {{ $tool->icon }}
            </div>
            <div>
                <div class="flex items-center gap-3 mb-1 flex-wrap">
                    <h1 class="text-2xl font-bold tracking-tight">{{ $tool->title }}</h1>
                    @if(str_contains($tool->tags ?? '', 'popular'))
                    <span
                        class="px-2 py-0.5 bg-fn-amber/10 border border-fn-amber/30 text-fn-amber text-sm font-semibold rounded-full">🔥
                        Popular</span>
                    @endif
                    @if(str_contains($tool->tags ?? '', 'new'))
                    <span
                        class="px-2 py-0.5 bg-fn-green/10 border border-fn-green/30 text-fn-green text-sm font-semibold rounded-full">New</span>
                    @endif
                </div>
                <p class="text-fn-text3 text-sm leading-relaxed max-w-xl">{{ $tool->description }}</p>
            </div>
        </div>

        {{-- Quick stats --}}
        <div class="flex items-center gap-6 flex-wrap">
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                <span>Secure &amp; private</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
                <span>Fast processing</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                <span>No sign-up required</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-fn-text3">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                <span>Free to use</span>
            </div>
        </div>

    </div>
</section>

{{-- ══ MAIN CONTENT ══ --}}
<div class="max-w-4xl mx-auto px-6 pb-24">

    {{-- ── UPLOAD / TOOL AREA ── --}}
    <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden mb-8">

        {{-- Tab bar (if tool has multiple modes) --}}
        {{-- <div class="flex border-b border-fn-text/8">
            <button class="px-5 py-3 text-sm font-medium text-fn-text border-b-2 border-fn-blue">Upload File</button>
            <button class="px-5 py-3 text-sm font-medium text-fn-text3 hover:text-fn-text2">Paste URL</button>
        </div> --}}

        {{-- Upload zone --}}
        <div id="upload-zone"
            class="relative flex flex-col items-center justify-center gap-4 p-12 cursor-pointer group transition-all"
            ondragover="event.preventDefault(); this.classList.add('drag-over')"
            ondragleave="this.classList.remove('drag-over')" ondrop="handleDrop(event)">

            {{-- Dashed border overlay --}}
            <div
                class="absolute inset-4 rounded-xl border-2 border-dashed border-fn-text/10 group-hover:border-fn-blue/40 transition-colors pointer-events-none">
            </div>

            {{-- Upload icon --}}
            <div
                class="w-14 h-14 rounded-2xl bg-fn-surface2 border border-fn-text/10 flex items-center justify-center group-hover:border-fn-blue/30 transition-colors">
                <svg class="w-7 h-7 text-fn-text3 group-hover:text-fn-blue transition-colors" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="17 8 12 3 7 8" />
                    <line x1="12" y1="3" x2="12" y2="15" />
                </svg>
            </div>

            {{-- Text --}}
            <div class="text-center relative z-10">
                <p class="font-semibold text-fn-text mb-1">
                    Drop your file here, or
                    <label for="file-input" class="text-fn-blue cursor-pointer hover:underline">browse</label>
                </p>
                <p class="text-fn-text3 text-sm">
                    Supports: <span id="supported-formats" class="font-mono">—</span>
                    &nbsp;·&nbsp; Max 200MB
                </p>
            </div>

            {{-- Hidden file input --}}
            <input id="file-input" type="file" class="hidden" onchange="handleFileSelect(this)" />
        </div>

        {{-- File preview (hidden by default) --}}
        <div id="file-preview" class="hidden px-6 pb-6">
            <div class="bg-fn-surface2 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-fn-surface border border-fn-text/10 flex items-center justify-center text-xl shrink-0"
                    id="preview-icon">📄</div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm text-fn-text truncate" id="preview-name">filename.pdf</p>
                    <p class="text-fn-text3 text-sm mt-0.5" id="preview-size">2.4 MB</p>
                </div>
                <button onclick="resetFile()"
                    class="text-fn-text3 hover:text-fn-red transition-colors p-1.5 rounded-lg hover:bg-fn-red/10">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            {{-- Options slot (tool-specific options go here) --}}
            <div id="tool-options" class="mt-4 hidden">
                {{-- Rendered dynamically or via partials --}}
            </div>

            {{-- Convert button --}}
            <button id="convert-btn" onclick="startConvert()"
                class="mt-4 w-full py-3 bg-fn-blue text-white font-semibold text-sm rounded-xl hover:bg-fn-blue/90 active:scale-[.99] transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="13 17 18 12 13 7" />
                    <polyline points="6 17 11 12 6 7" />
                </svg>
                Convert Now
            </button>
        </div>

        {{-- Progress bar (hidden by default) --}}
        <div id="progress-wrap" class="hidden px-6 pb-6">
            <div class="bg-fn-surface2 rounded-xl p-5">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium text-fn-text">Processing…</p>
                    <span id="progress-pct" class="text-sm font-mono text-fn-text3">0%</span>
                </div>
                <div class="h-1.5 bg-fn-surface rounded-full overflow-hidden">
                    <div id="progress-bar" class="h-full bg-fn-blue rounded-full transition-all duration-300"
                        style="width:0%"></div>
                </div>
                <p class="text-fn-text3 text-sm mt-3 text-center" id="progress-label">Uploading file…</p>
            </div>
        </div>

        {{-- Result (hidden by default) --}}
        <div id="result-wrap" class="hidden px-6 pb-6">
            <div class="bg-fn-green/8 border border-fn-green/20 rounded-xl p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-fn-green/15 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-fn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-fn-text">Done! Your file is ready.</p>
                    <p class="text-fn-text3 text-sm mt-0.5" id="result-filename">output.docx</p>
                </div>
                <a id="download-btn" href="#" download
                    class="shrink-0 px-4 py-2 bg-fn-green text-white text-sm font-semibold rounded-lg hover:bg-fn-green/90 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" y1="15" x2="12" y2="3" />
                    </svg>
                    Download
                </a>
            </div>
            <button onclick="resetAll()"
                class="mt-3 w-full py-2.5 bg-fn-surface2 text-fn-text2 text-sm font-medium rounded-xl hover:bg-fn-surface border border-fn-text/8 transition-colors">
                Convert Another File
            </button>
        </div>

    </div>

    {{-- ── HOW IT WORKS ── --}}
    {{-- <div class="mb-10">
        <h2 class="text-base font-bold tracking-tight mb-5">How it works</h2>
        <div class="grid sm:grid-cols-3 gap-4">
            @foreach([
            ['1', 'Upload your file', 'Drag & drop or click to select your file from your device.', '📂'],
            ['2', 'We process it', 'Our servers convert your file instantly with high accuracy.', '⚙️'],
            ['3', 'Download result', 'Your converted file is ready to download in seconds.', '✅'],
            ] as [$step, $title, $desc, $icon])
            <div class="bg-fn-surface border border-fn-text/8 rounded-xl p-5 flex gap-4 items-start">
                <div
                    class="w-8 h-8 rounded-lg bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-fn-blue text-sm font-bold shrink-0">
                    {{ $step }}
                </div>
                <div>
                    <p class="font-semibold text-sm mb-1">{{ $title }}</p>
                    <p class="text-fn-text3 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div> --}}

    {{-- ── RELATED TOOLS ── --}}
    @if($relatedTools->isNotEmpty())
    <div class="mb-10">
        <h2 class="text-base font-bold tracking-tight mb-5">Related tools</h2>
        <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3">
            @foreach($relatedTools as $related)
            <a href="/tools/{{ $related->slug }}"
                class="bg-fn-surface border border-fn-text/8 rounded-xl p-4 flex items-center gap-3.5 hover:border-fn-text/20 transition-colors group">
                <div
                    class="w-9 h-9 rounded-lg bg-fn-surface2 border border-fn-text/10 flex items-center justify-center text-base shrink-0">
                    {{ $related->icon }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm">{{ $related->name }}</p>
                    <p class="text-fn-text3 text-sm truncate">{{ $related->description }}</p>
                </div>
                <svg class="w-4 h-4 text-fn-text3 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <line x1="7" y1="17" x2="17" y2="7" />
                    <polyline points="7 7 17 7 17 17" />
                </svg>
            </a>
            @endforeach
        </div>
    </div>
    @endif


</div>

<x-faqs />

@push('footer')
    <script>
        // ── File formats per tool slug ──
            const toolFormats = {
                'pdf-to-word':    { accept: '.pdf', formats: 'PDF', icon: '📕' },
                'pdf-to-excel':   { accept: '.pdf', formats: 'PDF', icon: '📕' },
                'pdf-to-jpg':     { accept: '.pdf', formats: 'PDF', icon: '📕' },
                'word-to-pdf':    { accept: '.doc,.docx', formats: 'DOC, DOCX', icon: '📄' },
                'merge-pdf':      { accept: '.pdf', formats: 'PDF', icon: '📕', multiple: true },
                'split-pdf':      { accept: '.pdf', formats: 'PDF', icon: '📕' },
                'compress-pdf':   { accept: '.pdf', formats: 'PDF', icon: '📕' },
                'compress-image': { accept: '.jpg,.jpeg,.png,.webp', formats: 'JPG, PNG, WebP', icon: '🖼️' },
                'resize-image':   { accept: '.jpg,.jpeg,.png,.webp', formats: 'JPG, PNG, WebP', icon: '🖼️' },
                'csv-to-json':    { accept: '.csv', formats: 'CSV', icon: '📊' },
                'json-to-csv':    { accept: '.json', formats: 'JSON', icon: '📊' },
                'excel-to-csv':   { accept: '.xlsx,.xls', formats: 'XLSX, XLS', icon: '📗' },
            };

            const slug = '{{ $tool->slug }}';
            const config = toolFormats[slug] || { accept: '*', formats: 'Any file', icon: '📄' };

            // Apply accepted formats
            document.getElementById('file-input').setAttribute('accept', config.accept);
            document.getElementById('supported-formats').textContent = config.formats;
            if (config.multiple) {
                document.getElementById('file-input').setAttribute('multiple', true);
            }

            let selectedFile = null;

            function handleDrop(e) {
                e.preventDefault();
                document.getElementById('upload-zone').classList.remove('drag-over');
                const file = e.dataTransfer.files[0];
                if (file) showPreview(file);
            }

            function handleFileSelect(input) {
                if (input.files[0]) showPreview(input.files[0]);
            }

            function showPreview(file) {
                selectedFile = file;
                document.getElementById('upload-zone').classList.add('hidden');
                document.getElementById('file-preview').classList.remove('hidden');
                document.getElementById('preview-name').textContent = file.name;
                document.getElementById('preview-icon').textContent = config.icon;
                document.getElementById('preview-size').textContent = formatBytes(file.size);
            }

            function resetFile() {
                selectedFile = null;
                document.getElementById('file-preview').classList.add('hidden');
                document.getElementById('upload-zone').classList.remove('hidden');
                document.getElementById('file-input').value = '';
            }

            function resetAll() {
                resetFile();
                document.getElementById('result-wrap').classList.add('hidden');
                document.getElementById('progress-wrap').classList.add('hidden');
            }

            function startConvert() {
                if (!selectedFile) return;

                // Show progress
                document.getElementById('file-preview').classList.add('hidden');
                document.getElementById('progress-wrap').classList.remove('hidden');

                // Build form data
                const formData = new FormData();
                formData.append('file', selectedFile);
                formData.append('_token', '{{ csrf_token() }}');

                // Simulate progress then POST
                let pct = 0;
                const bar = document.getElementById('progress-bar');
                const pctLabel = document.getElementById('progress-pct');
                const label = document.getElementById('progress-label');

                const tick = setInterval(() => {
                    pct = Math.min(pct + Math.random() * 15, 85);
                    bar.style.width = pct + '%';
                    pctLabel.textContent = Math.round(pct) + '%';
                    if (pct > 40) label.textContent = 'Converting…';
                }, 300);

                fetch('/tools/{{ $tool->slug }}/process', {
                    method: 'POST',
                    body: formData,
                })
                .then(res => {
                    if (!res.ok) throw new Error('Conversion failed');
                    return res.blob();
                })
                .then(blob => {
                    clearInterval(tick);
                    bar.style.width = '100%';
                    pctLabel.textContent = '100%';

                    setTimeout(() => {
                        document.getElementById('progress-wrap').classList.add('hidden');
                        document.getElementById('result-wrap').classList.remove('hidden');

                        const url = URL.createObjectURL(blob);
                        const ext = config.formats.split(',')[0].trim().toLowerCase();
                        const outName = selectedFile.name.replace(/\.[^.]+$/, '') + '.' + ext;

                        document.getElementById('download-btn').href = url;
                        document.getElementById('download-btn').download = outName;
                        document.getElementById('result-filename').textContent = outName;
                    }, 400);
                })
                .catch(() => {
                    clearInterval(tick);
                    document.getElementById('progress-wrap').classList.add('hidden');
                    document.getElementById('file-preview').classList.remove('hidden');
                    alert('Something went wrong. Please try again.');
                });
            }

            function formatBytes(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(1) + ' MB';
            }
    </script>
@endpush

@endsection
