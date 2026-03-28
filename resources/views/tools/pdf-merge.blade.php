{{-- resources/views/tools/merge-pdf.blade.php --}}
@extends('layouts.base')

@section('title', 'Merge PDF Files – Free Online | Filenewer')

@section('content')

<x-tool-hero :tool="$tool" />

{{-- ══ CONVERTER CARD ══ --}}
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- Step indicator --}}
            <div class="flex items-center justify-center gap-0 px-8 py-5 border-b border-fn-text/7 bg-fn-surface2">
                @php $steps = [['1','Add PDFs'],['2','Merging'],['3','Download']]; @endphp
                @foreach($steps as [$n, $label])
                <div class="step-item {{ $n === '1' ? 'active' : '' }} flex items-center gap-2" id="step-{{ $n }}">
                    <div
                        class="step-dot w-6 h-6 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center transition-all duration-300">
                        <span class="text-xs font-bold">{{ $n }}</span>
                    </div>
                    <span class="step-label text-xs font-semibold text-fn-text3 transition-colors">{{ $label }}</span>
                </div>
                @if($n !== '3')
                <div class="w-10 h-px bg-fn-text/10 mx-2"></div>
                @endif
                @endforeach
            </div>

            <div class="p-8 lg:p-10">

                {{-- ── STATE: Upload ── --}}
                <div id="state-upload">

                    {{-- Drop zone --}}
                    <div id="drop-zone"
                        class="drop-zone border-2 border-dashed border-fn-text/15 rounded-2xl p-10 text-center cursor-pointer hover:border-fn-blue/40 hover:bg-fn-blue/4 relative">
                        <div class="flex items-center justify-center mb-5">
                            <div
                                class="w-20 h-20 rounded-2xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-4xl">
                                📎</div>
                        </div>
                        <h2 class="text-lg font-bold mb-2">Drop your PDFs here</h2>
                        <p class="text-fn-text3 text-sm mb-6">or click to browse — select multiple files at once</p>
                        <div
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-fn-blue hover:bg-fn-blue-l text-white text-sm font-semibold rounded-xl transition-all pointer-events-none">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                            Choose PDF Files
                        </div>
                        <p class="text-fn-text3 text-xs mt-5">Max 20 files · 50MB each free · <a href=""
                                class="text-fn-blue-l hover:underline">More on Pro</a></p>
                        <input type="file" id="file-input" accept=".pdf,application/pdf" multiple
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                    </div>

                    {{-- File list --}}
                    <div id="file-list-wrap" class="hidden mt-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold text-fn-text2 flex items-center gap-2">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="text-fn-blue-l">
                                    <line x1="8" y1="6" x2="21" y2="6" />
                                    <line x1="8" y1="12" x2="21" y2="12" />
                                    <line x1="8" y1="18" x2="21" y2="18" />
                                    <line x1="3" y1="6" x2="3.01" y2="6" />
                                    <line x1="3" y1="12" x2="3.01" y2="12" />
                                    <line x1="3" y1="18" x2="3.01" y2="18" />
                                </svg>
                                Drag rows to reorder · <span id="file-count" class="text-fn-blue-l">0 files</span>
                            </p>
                            <button type="button" id="add-more-btn"
                                class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-fn-blue-l hover:text-white hover:bg-fn-blue border border-fn-blue/30 rounded-lg transition-all relative">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Add more
                                <input type="file" id="add-more-input" accept=".pdf,application/pdf" multiple
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </button>
                        </div>
                        <ul id="file-list" class="space-y-2 max-h-72 overflow-y-auto pr-1"></ul>
                        <div
                            class="mt-3 pt-3 border-t border-fn-text/7 flex items-center justify-between text-xs text-fn-text3">
                            <span id="total-size-label">Total: —</span>
                            <button type="button" id="clear-all-btn"
                                class="text-fn-red/70 hover:text-fn-red transition-colors font-semibold">Clear
                                all</button>
                        </div>
                    </div>

                    {{-- Options --}}
                    <div class="mt-6 grid sm:grid-cols-2 gap-3">
                        <div class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl">
                            <label class="text-xs font-semibold text-fn-text2 block mb-2">Output File Name</label>
                            <input type="text" id="opt-filename" value="merged" placeholder="merged"
                                class="w-full bg-fn-surface border border-fn-text/10 text-fn-text text-sm rounded-lg px-3 py-2 font-sans focus:outline-none focus:border-fn-blue/40 placeholder-fn-text3" />
                            <p class="text-fn-text3 text-xs mt-1">.pdf will be added automatically</p>
                        </div>
                        <div
                            class="p-4 bg-fn-surface2 border border-fn-text/8 rounded-xl flex flex-col justify-center gap-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-bookmarks" checked
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Add bookmarks per file</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-page-numbers"
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Add page numbers</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="opt-compress"
                                    class="w-4 h-4 rounded border border-fn-text/20 bg-fn-surface accent-fn-blue" />
                                <span class="text-xs text-fn-text2">Compress output</span>
                            </label>
                        </div>
                    </div>

                    {{-- Error banner --}}
                    <div id="upload-error"
                        class="hidden mt-4 items-center gap-3 px-4 py-3 bg-fn-red/8 border border-fn-red/25 rounded-xl text-sm text-fn-text2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" class="text-fn-red shrink-0" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <span id="error-text">Something went wrong.</span>
                    </div>

                    {{-- Merge button --}}
                    <button id="merge-btn" type="button" disabled
                        class="mt-6 w-full py-3.5 bg-fn-blue text-white font-bold text-base rounded-xl transition-all disabled:opacity-40 disabled:cursor-not-allowed hover:enabled:bg-fn-blue-l hover:enabled:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 6H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-3" />
                            <rect x="8" y="2" width="8" height="8" rx="1" />
                        </svg>
                        Merge PDFs
                    </button>

                </div>

                {{-- ── STATE: Merging ── --}}
                <div id="state-converting" class="hidden text-center py-6">
                    <div class="flex items-center justify-center gap-3 mb-8 flex-wrap">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-2xl">
                            📄</div>
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/10 border border-fn-amber/20 flex items-center justify-center text-2xl">
                            📄</div>
                        <div class="flex gap-1">
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:0s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.15s"></span>
                            <span class="w-2 h-2 rounded-full bg-fn-blue-l animate-bounce"
                                style="animation-delay:.3s"></span>
                        </div>
                        <div
                            class="w-16 h-16 rounded-2xl bg-fn-blue/10 border border-fn-blue/20 flex items-center justify-center text-3xl">
                            📎</div>
                    </div>

                    <h2 class="text-xl font-bold mb-2">Merging your files…</h2>
                    <p class="text-fn-text3 text-sm mb-8">Please wait, this usually takes under 15 seconds</p>

                    <div class="max-w-md mx-auto mb-3">
                        <div class="h-2 bg-fn-surface2 rounded-full overflow-hidden border border-fn-text/8">
                            <div class="progress-fill" id="progress-fill" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between max-w-md mx-auto text-xs text-fn-text3 mb-8">
                        <span id="progress-label">Starting…</span>
                        <span id="progress-pct" class="font-mono font-semibold text-fn-text2">0%</span>
                    </div>

                    @php
                    $procSteps = [
                    ['proc-1', 'Uploading & validating files'],
                    ['proc-2', 'Reading PDF structures'],
                    ['proc-3', 'Combining pages & bookmarks'],
                    ['proc-4', 'Finalising merged document'],
                    ];
                    @endphp
                    <div class="max-w-xs mx-auto flex flex-col gap-3 text-left">
                        @foreach($procSteps as [$pid, $plabel])
                        <div class="flex items-center gap-3" id="{{ $pid }}">
                            <div
                                class="step-dot w-5 h-5 rounded-full border-2 border-fn-text/20 bg-fn-surface flex items-center justify-center shrink-0 transition-all duration-300">
                                <svg class="check-icon hidden w-3 h-3 text-fn-green" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                <svg class="spin-icon hidden w-3 h-3 text-fn-blue-l spin" viewBox="0 0 24 24"
                                    fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"
                                        stroke-dasharray="60" stroke-dashoffset="20" stroke-linecap="round" />
                                </svg>
                            </div>
                            <span class="text-xs text-fn-text3">{{ $plabel }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── STATE: Download ── --}}
                <div id="state-download" class="hidden text-center py-6">
                    <div
                        class="w-20 h-20 rounded-2xl bg-fn-green/12 border border-fn-green/25 flex items-center justify-center text-4xl mx-auto mb-5">
                        ✅</div>
                    <h2 class="text-2xl font-bold mb-2">Merge Complete!</h2>
                    <p class="text-fn-text2 text-sm mb-2">Your merged PDF is ready to download.</p>
                    <p class="text-fn-text3 text-xs mb-8">
                        File will be deleted in <span class="text-fn-amber font-semibold font-mono"
                            id="expiry-timer">60:00</span>
                    </p>

                    <div
                        class="max-w-sm mx-auto p-4 bg-fn-surface2 border border-fn-green/15 rounded-xl flex items-center gap-4 mb-6 text-left">
                        <div
                            class="w-12 h-12 rounded-xl bg-fn-amber/12 border border-fn-amber/20 flex items-center justify-center text-2xl shrink-0">
                            📎</div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" id="output-name">merged.pdf</p>
                            <p class="text-fn-text3 text-xs mt-0.5" id="output-meta">PDF Document</p>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-fn-green animate-pulse shrink-0"></span>
                    </div>

                    <a id="download-link" href="#"
                        class="inline-flex items-center gap-2.5 px-8 py-3.5 text-white font-bold text-base rounded-xl transition-all hover:-translate-y-0.5 mb-4"
                        style="background: oklch(67% 0.18 162);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" y1="15" x2="12" y2="3" />
                        </svg>
                        Download Merged PDF
                    </a>

                    <div class="flex items-center justify-center gap-3 flex-wrap">
                        <button type="button" onclick="resetMerger()"
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.5" />
                            </svg>
                            Merge more files
                        </button>
                        <a href=""
                            class="flex items-center gap-2 px-4 py-2 bg-fn-surface border border-fn-text/10 text-fn-text2 text-sm font-semibold rounded-xl hover:text-fn-text hover:bg-fn-surface2 transition-all">
                            All tools
                        </a>
                    </div>

                    <p class="mt-6 text-fn-text3 text-xs flex items-center justify-center gap-1.5">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-fn-green">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                        Your files are encrypted and permanently deleted within 1 hour.
                    </p>
                </div>

            </div>{{-- /card body --}}
        </div>{{-- /card --}}
    </div>
</section>


{{-- ══ FAQ ══ --}}
<x-faqs />

{{-- ══ RELATED TOOLS ══ --}}
<x-tools-section />

{{-- ══ JAVASCRIPT ══ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

    const dropZone     = document.getElementById('drop-zone');
    const fileInput    = document.getElementById('file-input');
    const addMoreInput = document.getElementById('add-more-input');
    const mergeBtn     = document.getElementById('merge-btn');
    const fileListWrap = document.getElementById('file-list-wrap');
    const fileListEl   = document.getElementById('file-list');
    const uploadError  = document.getElementById('upload-error');
    const errorText    = document.getElementById('error-text');

    let files          = [];
    let expiryInterval = null;
    let dragSrcIndex   = null;

    // ── Drag & drop on zone ──
    ['dragenter','dragover'].forEach(evt => {
        dropZone.addEventListener(evt, e => {
            e.preventDefault(); e.stopPropagation();
            dropZone.classList.add('drag-over');
        });
    });

    ['dragleave','dragend','drop'].forEach(evt => {
        dropZone.addEventListener(evt, e => {
            e.preventDefault(); e.stopPropagation();
            dropZone.classList.remove('drag-over');
        });
    });

    dropZone.addEventListener('drop', e => {
        addFiles(Array.from(e.dataTransfer.files));
    });

    fileInput.addEventListener('change', e => {
        addFiles(Array.from(e.target.files));
        e.target.value = '';
    });

    addMoreInput.addEventListener('change', e => {
        addFiles(Array.from(e.target.files));
        e.target.value = '';
    });

    document.getElementById('clear-all-btn').addEventListener('click', () => {
        files = [];
        renderFileList();
    });

    // ── Add files ──
    function addFiles(newFiles) {
        hideError();
        for (const f of newFiles) {
            if (f.type !== 'application/pdf' && !f.name.toLowerCase().endsWith('.pdf')) {
                showError(`"${f.name}" is not a PDF file.`);
                continue;
            }
            if (f.size > 50 * 1024 * 1024) {
                showError(`"${f.name}" exceeds the 50MB limit.`);
                continue;
            }
            if (files.length >= 20) {
                showError('Maximum 20 files allowed on the free plan.');
                break;
            }
            files.push(f);
        }
        renderFileList();
    }

    // ── Render file list ──
    function renderFileList() {
        fileListEl.innerHTML = '';

        if (files.length === 0) {
            fileListWrap.classList.add('hidden');
            dropZone.classList.remove('has-files');
            mergeBtn.disabled = true;
            return;
        }

        fileListWrap.classList.remove('hidden');
        dropZone.classList.add('has-files');
        mergeBtn.disabled = files.length < 2;

        document.getElementById('file-count').textContent = files.length + ' file' + (files.length !== 1 ? 's' : '');

        const totalBytes = files.reduce((s, f) => s + f.size, 0);
        document.getElementById('total-size-label').textContent = 'Total: ' + formatBytes(totalBytes);

        files.forEach((file, idx) => {
            const li = document.createElement('li');
            li.className = 'file-row flex items-center gap-3 p-3 bg-fn-surface2 border border-fn-text/8 rounded-xl';
            li.draggable = true;
            li.dataset.index = idx;

            li.innerHTML = `
                <div class="drag-handle text-fn-text3 hover:text-fn-text2 shrink-0 transition-colors" title="Drag to reorder">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="8" y1="18" x2="16" y2="18"/>
                    </svg>
                </div>
                <div class="w-8 h-8 rounded-lg bg-fn-red/10 border border-fn-red/20 flex items-center justify-center text-lg shrink-0">📕</div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-xs truncate">${escHtml(file.name)}</p>
                    <p class="text-fn-text3 text-xs">${formatBytes(file.size)}</p>
                </div>
                <span class="page-badge text-xs font-mono text-fn-text3 shrink-0">#${idx + 1}</span>
                <button type="button" data-remove="${idx}" class="shrink-0 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-fn-red/10 text-fn-text3 hover:text-fn-red transition-all">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            `;

            li.querySelector('[data-remove]').addEventListener('click', e => {
                e.stopPropagation();
                files.splice(parseInt(e.currentTarget.dataset.remove), 1);
                renderFileList();
            });

            li.addEventListener('dragstart', e => {
                dragSrcIndex = idx;
                setTimeout(() => li.classList.add('dragging'), 0);
                e.dataTransfer.effectAllowed = 'move';
            });
            li.addEventListener('dragend', () => {
                li.classList.remove('dragging');
                document.querySelectorAll('.file-row').forEach(r => r.classList.remove('drag-target'));
            });
            li.addEventListener('dragover', e => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                document.querySelectorAll('.file-row').forEach(r => r.classList.remove('drag-target'));
                li.classList.add('drag-target');
            });
            li.addEventListener('drop', e => {
                e.preventDefault(); e.stopPropagation();
                const targetIndex = parseInt(li.dataset.index);
                if (dragSrcIndex !== null && dragSrcIndex !== targetIndex) {
                    const moved = files.splice(dragSrcIndex, 1)[0];
                    files.splice(targetIndex, 0, moved);
                    renderFileList();
                }
                dragSrcIndex = null;
            });

            fileListEl.appendChild(li);
        });
    }

    // ── Merge button ──
    mergeBtn.addEventListener('click', startMerge);

    async function startMerge() {
        if (files.length < 2) return;
        hideError();
        showState('converting');
        updateStepIndicator(2);

        const formData = new FormData();
        files.forEach(f => formData.append('pdfs[]', f));
        formData.append('filename',     document.getElementById('opt-filename').value || 'merged');
        formData.append('bookmarks',    document.getElementById('opt-bookmarks').checked    ? '1' : '0');
        formData.append('page_numbers', document.getElementById('opt-page-numbers').checked ? '1' : '0');
        formData.append('compress',     document.getElementById('opt-compress').checked     ? '1' : '0');
        formData.append('_token',       '{{ csrf_token() }}');

        setProcessStep('proc-1', 'active');
        animateProgress(0, 20, 800, 'Uploading files…');

        const t2 = setTimeout(() => {
            setProcessStep('proc-1', 'done');
            setProcessStep('proc-2', 'active');
            animateProgress(20, 50, 1000, 'Reading PDF structures…');
        }, 1000);

        const t3 = setTimeout(() => {
            setProcessStep('proc-2', 'done');
            setProcessStep('proc-3', 'active');
            animateProgress(50, 75, 1200, 'Combining pages…');
        }, 2200);

        const t4 = setTimeout(() => {
            setProcessStep('proc-3', 'done');
            setProcessStep('proc-4', 'active');
            animateProgress(75, 90, 1000, 'Finalising document…');
        }, 3600);

        try {
            const res  = await fetch('', {
                method: 'POST',
                body:   formData,
            });

            clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);

            const data = await res.json();

            if (!res.ok || !data.success) {
                throw new Error(data.message || 'Merge failed. Please try again.');
            }

            setProcessStep('proc-3', 'done');
            setProcessStep('proc-4', 'done');
            animateProgress(90, 100, 400, 'Done!');

            const outName = (document.getElementById('opt-filename').value || 'merged').replace(/\.pdf$/i, '') + '.pdf';

            setTimeout(() => {
                document.getElementById('download-link').href      = data.download_url;
                document.getElementById('output-name').textContent = outName;
                document.getElementById('output-meta').textContent = formatBytes(data.file_size) + ' · ' + data.page_count + ' pages · PDF Document';
                showState('download');
                updateStepIndicator(3);
                startExpiryTimer(3600);
            }, 500);

        } catch (err) {
            clearTimeout(t2); clearTimeout(t3); clearTimeout(t4);
            showError(err.message || 'Something went wrong. Please try again.');
            showState('upload');
            updateStepIndicator(1);
        }
    }

    // ── State switcher ──
    function showState(state) {
        ['upload','converting','download'].forEach(s => {
            document.getElementById('state-' + s).classList.toggle('hidden', s !== state);
        });
        if (state === 'download') {
            document.getElementById('state-download').classList.add('bounce-in');
        }
    }

    // ── Step indicator ──
    function updateStepIndicator(active) {
        [1,2,3].forEach(n => {
            const el = document.getElementById('step-' + n);
            el.classList.remove('active','done');
            if (n < active)   el.classList.add('done');
            if (n === active) el.classList.add('active');
        });
    }

    // ── Processing steps ──
    function setProcessStep(id, state) {
        const el = document.getElementById(id);
        if (!el) return;
        const dot   = el.querySelector('.step-dot');
        const check = el.querySelector('.check-icon');
        const spin  = el.querySelector('.spin-icon');

        check.classList.add('hidden');
        spin.classList.add('hidden');
        dot.style.borderColor = '';
        dot.style.background  = '';

        if (state === 'active') {
            spin.classList.remove('hidden');
            dot.style.borderColor = 'oklch(49% 0.24 264)';
            dot.style.background  = 'oklch(49% 0.24 264 / 15%)';
        }
        if (state === 'done') {
            check.classList.remove('hidden');
            dot.style.borderColor = 'oklch(67% 0.18 162)';
            dot.style.background  = 'oklch(67% 0.18 162 / 15%)';
        }
    }

    // ── Progress bar ──
    function animateProgress(from, to, duration, label) {
        document.getElementById('progress-label').textContent = label;
        const start = performance.now();
        function step(now) {
            const t   = Math.min((now - start) / duration, 1);
            const pct = Math.round(from + (to - from) * t);
            document.getElementById('progress-fill').style.width = pct + '%';
            document.getElementById('progress-pct').textContent  = pct + '%';
            if (t < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    // ── Expiry countdown ──
    function startExpiryTimer(seconds) {
        clearInterval(expiryInterval);
        let rem = seconds;
        expiryInterval = setInterval(() => {
            rem--;
            const m  = String(Math.floor(rem / 60)).padStart(2,'0');
            const s  = String(rem % 60).padStart(2,'0');
            const el = document.getElementById('expiry-timer');
            if (el) el.textContent = m + ':' + s;
            if (rem <= 0) clearInterval(expiryInterval);
        }, 1000);
    }

    // ── Reset ──
    window.resetMerger = function () {
        files = [];
        renderFileList();
        showState('upload');
        updateStepIndicator(1);
        clearInterval(expiryInterval);
        animateProgress(0, 0, 0, 'Starting…');
        ['proc-1','proc-2','proc-3','proc-4'].forEach(id => setProcessStep(id, ''));
    };

    // ── Error helpers ──
    function showError(msg) {
        errorText.textContent = msg;
        uploadError.classList.remove('hidden');
        uploadError.classList.add('flex');
    }
    function hideError() {
        uploadError.classList.add('hidden');
        uploadError.classList.remove('flex');
    }

    // ── Helpers ──
    function formatBytes(bytes) {
        if (bytes < 1024)    return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function escHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // ── FAQ accordion ──
    document.querySelectorAll('.faq-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const body   = btn.nextElementSibling;
            const icon   = btn.querySelector('.faq-icon');
            const isOpen = !body.classList.contains('hidden');

            document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');

            if (!isOpen) {
                body.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

}); // end DOMContentLoaded
</script>

@endsection
