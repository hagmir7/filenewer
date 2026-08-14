@extends('layouts.base')

@push('scripts')
<x-ld-json :tool="$tool" />
@endpush


@section('content')

<x-tool-hero :tool="$tool" />


{{-- ══ PREVIEWER CARD ══ --}}
<section class="pb-10 sm:pb-16">
    <div class="max-w-7xl mx-auto px-3 sm:px-6">
        <div class="bg-fn-surface border border-fn-text/8 rounded-2xl overflow-hidden shadow-2xl">

            {{-- ── EDITOR + PREVIEW SPLIT ── --}}
            <div class="flex flex-col lg:flex-row" style="min-height: 70vh;">

                {{-- ══ LEFT: Editor pane ══ --}}
                <div class="flex flex-col lg:w-1/2 border-b lg:border-b-0 lg:border-r border-fn-text/8" id="editor-pane">

                    {{-- Editor toolbar --}}
                    <div class="flex items-center justify-between px-3 sm:px-4 py-2.5 bg-fn-surface2 border-b border-fn-text/8 shrink-0">
                        <div class="flex items-center gap-2">
                            {{-- Traffic-light dots --}}
                            <div class="flex gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-fn-red/50"></span>
                                <span class="w-3 h-3 rounded-full bg-fn-amber/50" style="background: oklch(82% 0.18 80 / 60%)"></span>
                                <span class="w-3 h-3 rounded-full bg-fn-green/50"></span>
                            </div>
                            <span class="text-xs font-semibold text-fn-text3 ml-1">HTML</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <button type="button" id="btn-sample" title="Load sample"
                                class="toolbar-btn px-2 py-1 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all flex items-center gap-1">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                Sample
                            </button>
                            <button type="button" id="btn-paste-editor" title="Paste from clipboard"
                                class="toolbar-btn px-2 py-1 text-fn-text3 hover:text-fn-text text-xs font-semibold rounded-lg transition-all flex items-center gap-1">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                                Paste
                            </button>
                            <button type="button" id="btn-format" title="Format HTML"
                                class="toolbar-btn px-2 py-1 text-fn-text3 hover:text-fn-blue text-xs font-semibold rounded-lg transition-all flex items-center gap-1">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="21" y1="10" x2="7" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="7" y2="18"/></svg>
                                Format
                            </button>
                            <button type="button" id="btn-clear-editor" title="Clear editor"
                                class="toolbar-btn px-2 py-1 text-fn-text3 hover:text-fn-red text-xs font-semibold rounded-lg transition-all">
                                Clear
                            </button>
                        </div>
                    </div>

                    {{-- Code textarea with line numbers overlay --}}
                    <div class="relative flex-1 overflow-hidden" id="editor-wrap">
                        <div class="absolute inset-0 flex">
                            {{-- Line numbers --}}
                            <div id="line-numbers"
                                class="select-none text-right text-xs font-mono text-fn-text3/40 leading-relaxed px-2 py-3 pt-3 shrink-0 overflow-hidden"
                                style="min-width: 2.8rem; background: var(--fn-surface2); border-right: 1px solid oklch(0% 0 0 / 6%)">
                                <div>1</div>
                            </div>
                            {{-- Textarea --}}
                            <textarea id="html-editor" spellcheck="false" autocomplete="off" autocorrect="off"
                                placeholder="Paste or type your HTML here…"
                                class="flex-1 resize-none bg-fn-surface text-fn-text text-xs sm:text-sm font-mono leading-relaxed px-4 py-3 focus:outline-none placeholder:text-fn-text3/30 overflow-auto"
                                style="tab-size: 2; -moz-tab-size: 2;"></textarea>
                        </div>
                    </div>

                    {{-- Editor status bar --}}
                    <div class="flex items-center justify-between px-3 sm:px-4 py-1.5 bg-fn-surface2 border-t border-fn-text/8 text-xs text-fn-text3 shrink-0">
                        <span id="editor-status">Ready</span>
                        <div class="flex items-center gap-3">
                            <span id="editor-meta">0 lines · 0 chars</span>
                            <span id="error-badge" class="hidden items-center gap-1 text-fn-red font-semibold">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span id="error-badge-text">0 issues</span>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- ══ RIGHT: Preview pane ══ --}}
                <div class="flex flex-col lg:w-1/2" id="preview-pane">

                    {{-- Preview toolbar --}}
                    <div class="flex items-center justify-between px-3 sm:px-4 py-2.5 bg-fn-surface2 border-b border-fn-text/8 shrink-0 gap-2">

                        {{-- Viewport switcher --}}
                        <div class="flex items-center gap-1 p-0.5 bg-fn-surface border border-fn-text/8 rounded-lg">
                            @foreach([
                                ['vp-desktop', 'desktop', 'M20 3H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM11 20h2m-4 1h8', 'Desktop'],
                                ['vp-tablet',  'tablet',  'M12 17h.01M7 21h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z', 'Tablet'],
                                ['vp-mobile',  'mobile',  'M12 18h.01M8 21h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2z', 'Mobile'],
                            ] as [$id, $val, $path, $label])
                            <button type="button" id="{{ $id }}" data-vp="{{ $val }}" title="{{ $label }}"
                                class="vp-btn {{ $val === 'desktop' ? 'active' : '' }} p-1.5 rounded-md transition-all">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="{{ $path }}"/>
                                </svg>
                            </button>
                            @endforeach
                        </div>

                        {{-- URL bar (fake) --}}
                        <div class="flex-1 mx-2 hidden sm:flex items-center gap-1.5 px-2.5 py-1 bg-fn-surface border border-fn-text/10 rounded-lg min-w-0">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-fn-green shrink-0"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            <span class="text-xs text-fn-text3 font-mono truncate">preview://local</span>
                        </div>

                        {{-- Right actions --}}
                        <div class="flex items-center gap-1 shrink-0">
                            <button type="button" id="btn-refresh" title="Refresh preview"
                                class="toolbar-btn p-1.5 text-fn-text3 hover:text-fn-text rounded-lg transition-all">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                            </button>
                            <button type="button" id="btn-theme-toggle" title="Toggle preview theme"
                                class="toolbar-btn p-1.5 text-fn-text3 hover:text-fn-text rounded-lg transition-all">
                                <svg id="icon-dark" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                                <svg id="icon-light" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                            </button>
                            <button type="button" id="btn-open-new" title="Open in new tab"
                                class="toolbar-btn p-1.5 text-fn-text3 hover:text-fn-text rounded-lg transition-all">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </button>
                            <button type="button" id="btn-download-html" title="Download as .html"
                                class="toolbar-btn p-1.5 text-fn-text3 hover:text-fn-green rounded-lg transition-all">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            </button>
                            {{-- Copy HTML --}}
                            <button type="button" id="btn-copy-html" title="Copy HTML"
                                class="toolbar-btn p-1.5 text-fn-text3 hover:text-fn-text rounded-lg transition-all">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Preview iframe wrapper --}}
                    <div class="flex-1 relative overflow-hidden bg-fn-surface" id="preview-outer" style="background: repeating-linear-gradient(45deg, oklch(0% 0 0 / 2%) 0, oklch(0% 0 0 / 2%) 1px, transparent 0, transparent 50%) 0 0 / 12px 12px;">
                        <div id="preview-frame-wrap" class="absolute inset-0 flex items-start justify-center transition-all duration-300 p-0" style="overflow: auto;">
                            <iframe id="preview-frame"
                                sandbox="allow-scripts allow-same-origin allow-forms allow-modals"
                                class="w-full h-full border-0 transition-all duration-300 bg-white"
                                style="min-height: 100%;"
                                title="HTML Preview"></iframe>
                        </div>

                        {{-- Empty state --}}
                        <div id="empty-state" class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 pointer-events-none">
                            <div class="w-16 h-16 rounded-2xl bg-fn-surface2 border border-fn-text/8 flex items-center justify-center mb-4">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-fn-text3">
                                    <polyline points="16 18 22 12 16 6"/>
                                    <polyline points="8 6 2 12 8 18"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-fn-text2 mb-1">No HTML yet</p>
                            <p class="text-sm text-fn-text3">Type or paste HTML on the left — the preview updates instantly</p>
                        </div>
                    </div>

                    {{-- Preview status bar --}}
                    <div class="flex items-center justify-between px-3 sm:px-4 py-1.5 bg-fn-surface2 border-t border-fn-text/8 text-xs text-fn-text3 shrink-0">
                        <span id="preview-status">Waiting for input…</span>
                        <span id="preview-size" class="font-mono"></span>
                    </div>
                </div>
            </div>

            {{-- ── BOTTOM TOOLBAR ── --}}
            <div class="flex flex-wrap items-center justify-between gap-2 px-4 sm:px-6 py-3 bg-fn-surface2 border-t border-fn-text/8">

                {{-- Quick-insert snippets --}}
                <div class="flex items-center gap-1.5 flex-wrap">
                    <span class="text-xs text-fn-text3 font-semibold mr-1 hidden sm:inline">Insert:</span>
                    @foreach([
                        ['snippet-table',    'Table'],
                        ['snippet-form',     'Form'],
                        ['snippet-card',     'Card'],
                        ['snippet-nav',      'Navbar'],
                        ['snippet-hero',     'Hero'],
                    ] as [$sid, $slabel])
                    <button type="button" id="{{ $sid }}"
                        class="snippet-btn px-2.5 py-1 bg-fn-surface border border-fn-text/10 text-fn-text3 hover:text-fn-text hover:border-fn-blue/30 text-xs font-semibold rounded-lg transition-all">
                        {{ $slabel }}
                    </button>
                    @endforeach
                </div>

                {{-- Auto-preview toggle --}}
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <div class="toggle-wrap relative w-8 h-4 shrink-0">
                        <input type="checkbox" id="auto-preview" checked class="sr-only peer" />
                        <div class="toggle-track w-8 h-4 rounded-full bg-fn-text/15 peer-checked:bg-fn-blue transition-colors"></div>
                        <div class="toggle-thumb absolute top-0.5 left-0.5 w-3 h-3 rounded-full bg-white shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="text-xs font-semibold text-fn-text3">Live preview</span>
                </label>
            </div>

        </div>
    </div>
</section>


{{-- ══ FEATURES ══ --}}
<section class="py-10 sm:py-14 border-t border-fn-text/7 bg-fn-surface2">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <h2 class="text-lg font-bold mb-1 text-center">What You Can Do</h2>
        <p class="text-fn-text3 text-sm text-center mb-8">A full HTML workbench — right in your browser</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            @foreach([
                ['⚡', 'Live preview',        'The iframe updates as you type — no button needed. Toggle off for large documents.'],
                ['📐', 'Viewport switching',  'Test your layout at desktop, tablet (768px), and mobile (390px) widths instantly.'],
                ['🎨', 'Dark/Light canvas',   'Toggle the preview background between white and dark to test your design on both.'],
                ['✂️',  'Quick snippets',      'Insert common patterns — tables, forms, cards, navbars, heroes — with one click.'],
                ['🔢', 'Line numbers',        'Always-visible line count so you can navigate large documents without guessing.'],
                ['💾', 'Download & open',     'Export your HTML as a .html file or open the preview in a new browser tab.'],
            ] as [$icon, $title, $desc])
            <div class="flex items-start gap-3 p-4 bg-fn-surface border border-fn-text/8 rounded-2xl">
                <span class="text-xl shrink-0 mt-0.5">{{ $icon }}</span>
                <div>
                    <p class="font-bold text-sm mb-0.5">{{ $title }}</p>
                    <p class="text-xs text-fn-text3 leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ══ FAQ ══ --}}
<section class="py-10 sm:py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <h2 class="text-xl sm:text-2xl font-bold tracking-tight mb-6 sm:mb-8 text-center">Frequently Asked Questions</h2>
        <div class="space-y-2 sm:space-y-3">
            @foreach([
                ['Is the preview safe — can scripts run?', 'Yes — the preview iframe runs with the sandbox attribute set to allow-scripts and allow-same-origin. This means JavaScript in your HTML will execute so you can test interactive components, but access to cookies, localStorage, and parent-frame resources is restricted.'],
                ['Does the content get sent anywhere?', 'No. Everything runs entirely in your browser. Your HTML is never sent to a server or stored anywhere. The preview is a local srcdoc iframe — closing the tab discards it completely.'],
                ['What is the dark/light canvas toggle?', 'It switches the preview iframe\'s background color between white (#ffffff) and a dark near-black. Useful for testing how your design looks on dark-mode backgrounds without adding any CSS to your HTML.'],
                ['Can I test responsive layouts?', 'Yes — the viewport switcher constrains the preview iframe to desktop (full width), tablet (768px), or mobile (390px). You can see exactly how your layout reflows at each breakpoint.'],
                ['What do the quick-insert snippets add?', 'Each snippet injects a self-contained HTML block at the cursor position (or end of document): Table adds a styled data table, Form adds a labelled input form, Card adds a content card, Navbar adds a navigation bar, and Hero adds a full-width hero section.'],
                ['Can I open the result in a new tab?', 'Yes — click the open-in-new-tab button in the preview toolbar. This writes the current HTML into a new blank window using document.write, so your full page — including scripts and styles — renders in a standalone browser tab.'],
            ] as [$q, $a])
            <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                <button type="button" class="faq-btn w-full flex items-center justify-between px-4 sm:px-5 py-3.5 sm:py-4 text-left hover:bg-fn-surface2 transition-colors">
                    <span class="font-semibold text-sm pr-3">{{ $q }}</span>
                    <svg class="faq-icon w-4 h-4 text-fn-text3 shrink-0 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-body hidden px-4 sm:px-5 pb-4">
                    <p class="text-fn-text2 text-sm leading-relaxed">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<x-tools-content :tool="$tool" />
<x-tools-section />

<style>
    /* ── Editor ── */
    #html-editor {
        caret-color: oklch(62% 0.20 250);
        line-height: 1.65;
    }
    #html-editor, #line-numbers {
        line-height: 1.65;
        font-size: 13px;
    }
    @media (min-width: 640px) {
        #html-editor, #line-numbers { font-size: 13.5px; }
    }
    #html-editor::-webkit-scrollbar,
    #line-numbers::-webkit-scrollbar { width: 4px; height: 4px; }
    #html-editor::-webkit-scrollbar-track,
    #line-numbers::-webkit-scrollbar-track { background: transparent; }
    #html-editor::-webkit-scrollbar-thumb { background: oklch(0% 0 0 / 15%); border-radius: 4px; }

    /* ── Editor/Preview min heights on mobile ── */
    #editor-pane  { min-height: 45vh; }
    #preview-pane { min-height: 45vh; }
    @media (min-width: 1024px) {
        #editor-pane, #preview-pane { min-height: 0; }
    }
    #editor-wrap { min-height: 0; flex: 1 1 0; }

    /* ── Toolbar buttons ── */
    .toolbar-btn {
        border-radius: 6px;
        transition: background .12s, color .12s;
    }
    .toolbar-btn:hover { background: oklch(0% 0 0 / 5%); }

    /* ── Viewport buttons ── */
    .vp-btn { color: var(--fn-text3); }
    .vp-btn.active {
        background: var(--fn-surface2);
        color: var(--fn-text);
        box-shadow: 0 1px 3px oklch(0% 0 0 / 10%);
    }

    /* ── Snippet buttons ── */
    .snippet-btn:hover { background: var(--fn-surface2); }

    /* ── Preview viewport frames ── */
    #preview-frame.vp-tablet { max-width: 768px; border-left: 1px solid oklch(0% 0 0 / 8%); border-right: 1px solid oklch(0% 0 0 / 8%); }
    #preview-frame.vp-mobile { max-width: 390px; border-left: 1px solid oklch(0% 0 0 / 8%); border-right: 1px solid oklch(0% 0 0 / 8%); border-radius: 16px; overflow: hidden; }

    /* ── Step indicator (if base layout uses it) ── */
    .step-item.active .step-dot  { border-color: oklch(49% 0.24 264); background: oklch(49% 0.24 264 / 12%); }
    .step-item.active .step-label { color: var(--fn-text); }
    .step-item.done .step-dot    { border-color: oklch(67% 0.18 162); background: oklch(67% 0.18 162 / 12%); }
</style>

@push('footer')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const editor     = document.getElementById('html-editor');
  const frame      = document.getElementById('preview-frame');
  const lineNums   = document.getElementById('line-numbers');
  const emptyState = document.getElementById('empty-state');

  let previewTheme = 'light'; // 'light' | 'dark'
  let autoPreview  = true;
  let previewTimer = null;
  let lastHtml     = '';

  // ── Sample HTML ──
  const SAMPLE_HTML = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sample Page</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: system-ui, sans-serif; color: #1a1a1a; background: #f9fafb; }

    /* Navbar */
    nav { background: #fff; border-bottom: 1px solid #e5e7eb; padding: 0 1.5rem; display: flex; align-items: center; justify-content: space-between; height: 56px; }
    nav .brand { font-weight: 700; font-size: 1.1rem; color: #2563eb; }
    nav ul { list-style: none; display: flex; gap: 1.5rem; }
    nav ul a { text-decoration: none; color: #374151; font-size: .9rem; font-weight: 500; }
    nav ul a:hover { color: #2563eb; }

    /* Hero */
    .hero { background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); color: #fff; padding: 4rem 1.5rem; text-align: center; }
    .hero h1 { font-size: clamp(1.8rem, 5vw, 3rem); font-weight: 800; margin-bottom: .75rem; }
    .hero p { font-size: 1.1rem; opacity: .85; max-width: 480px; margin: 0 auto 1.75rem; }
    .btn { display: inline-block; padding: .65rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: .9rem; text-decoration: none; transition: opacity .15s; }
    .btn-white { background: #fff; color: #2563eb; }
    .btn-outline { border: 2px solid rgba(255,255,255,.5); color: #fff; margin-left: .5rem; }
    .btn:hover { opacity: .88; }

    /* Cards */
    .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; padding: 2rem 1.5rem; max-width: 900px; margin: 0 auto; }
    .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.25rem; }
    .card-icon { font-size: 1.8rem; margin-bottom: .6rem; }
    .card h3 { font-size: .95rem; font-weight: 700; margin-bottom: .35rem; }
    .card p { font-size: .85rem; color: #6b7280; line-height: 1.5; }

    /* Table */
    .table-section { padding: 0 1.5rem 2.5rem; max-width: 900px; margin: 0 auto; }
    .table-section h2 { font-size: 1.1rem; font-weight: 700; margin-bottom: .75rem; }
    table { width: 100%; border-collapse: collapse; font-size: .875rem; }
    th { background: #f3f4f6; text-align: left; padding: .6rem .85rem; font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb; }
    td { padding: .6rem .85rem; border-bottom: 1px solid #f3f4f6; }
    tr:last-child td { border-bottom: none; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .badge-green { background: #dcfce7; color: #15803d; }
    .badge-amber { background: #fef9c3; color: #a16207; }
    .badge-red   { background: #fee2e2; color: #b91c1c; }
  </style>
</head>
<body>

  <nav>
    <span class="brand">⚡ Filenewer</span>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Tools</a></li>
      <li><a href="#">Docs</a></li>
    </ul>
  </nav>

  <section class="hero">
    <h1>Build Something Great</h1>
    <p>Paste any HTML and see it rendered live. Test layouts, components, and styles instantly.</p>
    <a href="#" class="btn btn-white">Get Started</a>
    <a href="#" class="btn btn-outline">Learn More</a>
  </section>

  <div class="cards">
    <div class="card"><div class="card-icon">🚀</div><h3>Fast</h3><p>Instant live preview as you type — no build step needed.</p></div>
    <div class="card"><div class="card-icon">📱</div><h3>Responsive</h3><p>Switch between desktop, tablet and mobile viewports.</p></div>
    <div class="card"><div class="card-icon">🔒</div><h3>Private</h3><p>Nothing is sent to any server. Runs entirely in your browser.</p></div>
  </div>

  <section class="table-section">
    <h2>Recent Activity</h2>
    <table>
      <thead>
        <tr><th>File</th><th>Type</th><th>Size</th><th>Status</th></tr>
      </thead>
      <tbody>
        <tr><td>report_q1.pdf</td><td>PDF → EPUB</td><td>2.4 MB</td><td><span class="badge badge-green">Done</span></td></tr>
        <tr><td>data_export.json</td><td>JSON → XML</td><td>148 KB</td><td><span class="badge badge-green">Done</span></td></tr>
        <tr><td>notebook_ml.ipynb</td><td>IPYNB → PDF</td><td>3.1 MB</td><td><span class="badge badge-amber">Processing</span></td></tr>
        <tr><td>archive_old.xlsx</td><td>Merge Excel</td><td>890 KB</td><td><span class="badge badge-red">Failed</span></td></tr>
      </tbody>
    </table>
  </section>

</body>
</html>`;

  // ── Snippets ──
  const SNIPPETS = {
    'snippet-table': `
<table style="width:100%;border-collapse:collapse;font-size:.9rem;">
  <thead>
    <tr style="background:#f3f4f6;">
      <th style="padding:.6rem .85rem;text-align:left;border-bottom:2px solid #e5e7eb;">Name</th>
      <th style="padding:.6rem .85rem;text-align:left;border-bottom:2px solid #e5e7eb;">Value</th>
      <th style="padding:.6rem .85rem;text-align:left;border-bottom:2px solid #e5e7eb;">Status</th>
    </tr>
  </thead>
  <tbody>
    <tr><td style="padding:.6rem .85rem;border-bottom:1px solid #f3f4f6;">Row 1</td><td style="padding:.6rem .85rem;border-bottom:1px solid #f3f4f6;">100</td><td style="padding:.6rem .85rem;border-bottom:1px solid #f3f4f6;">Active</td></tr>
    <tr><td style="padding:.6rem .85rem;border-bottom:1px solid #f3f4f6;">Row 2</td><td style="padding:.6rem .85rem;border-bottom:1px solid #f3f4f6;">200</td><td style="padding:.6rem .85rem;border-bottom:1px solid #f3f4f6;">Inactive</td></tr>
  </tbody>
</table>`,

    'snippet-form': `
<form style="max-width:400px;display:flex;flex-direction:column;gap:.75rem;font-family:system-ui,sans-serif;font-size:.9rem;">
  <div>
    <label style="display:block;font-weight:600;margin-bottom:.3rem;">Name</label>
    <input type="text" placeholder="Your name" style="width:100%;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:8px;outline:none;font-size:.9rem;">
  </div>
  <div>
    <label style="display:block;font-weight:600;margin-bottom:.3rem;">Email</label>
    <input type="email" placeholder="you@example.com" style="width:100%;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:8px;outline:none;font-size:.9rem;">
  </div>
  <div>
    <label style="display:block;font-weight:600;margin-bottom:.3rem;">Message</label>
    <textarea rows="4" placeholder="Write something…" style="width:100%;padding:.5rem .75rem;border:1px solid #d1d5db;border-radius:8px;outline:none;font-size:.9rem;resize:vertical;"></textarea>
  </div>
  <button type="button" style="padding:.6rem 1.25rem;background:#2563eb;color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer;">Submit</button>
</form>`,

    'snippet-card': `
<div style="max-width:320px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;font-family:system-ui,sans-serif;box-shadow:0 2px 8px rgba(0,0,0,.06);">
  <div style="height:140px;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:3rem;">🎨</div>
  <div style="padding:1.1rem;">
    <h3 style="margin:0 0 .35rem;font-size:1rem;font-weight:700;">Card Title</h3>
    <p style="margin:0 0 1rem;font-size:.85rem;color:#6b7280;line-height:1.5;">A description of this card goes here. Keep it short and clear.</p>
    <a href="#" style="display:inline-block;padding:.45rem 1rem;background:#2563eb;color:#fff;border-radius:6px;font-size:.8rem;font-weight:600;text-decoration:none;">Action</a>
  </div>
</div>`,

    'snippet-nav': `
<nav style="background:#fff;border-bottom:1px solid #e5e7eb;padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:56px;font-family:system-ui,sans-serif;">
  <span style="font-weight:700;font-size:1.05rem;color:#2563eb;">Brand</span>
  <ul style="list-style:none;display:flex;gap:1.5rem;margin:0;padding:0;">
    <li><a href="#" style="text-decoration:none;color:#374151;font-size:.9rem;font-weight:500;">Home</a></li>
    <li><a href="#" style="text-decoration:none;color:#374151;font-size:.9rem;font-weight:500;">About</a></li>
    <li><a href="#" style="text-decoration:none;color:#374151;font-size:.9rem;font-weight:500;">Contact</a></li>
  </ul>
  <button style="padding:.45rem 1rem;background:#2563eb;color:#fff;border:none;border-radius:8px;font-size:.85rem;font-weight:600;cursor:pointer;">Sign in</button>
</nav>`,

    'snippet-hero': `
<section style="background:linear-gradient(135deg,#1e3a8a 0%,#7c3aed 100%);color:#fff;padding:5rem 1.5rem;text-align:center;font-family:system-ui,sans-serif;">
  <p style="font-size:.8rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;opacity:.7;margin-bottom:.75rem;">Introducing v2.0</p>
  <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;line-height:1.15;margin-bottom:1rem;">Your headline<br>goes right here</h1>
  <p style="font-size:1.1rem;opacity:.8;max-width:500px;margin:0 auto 2rem;line-height:1.6;">A short supporting sentence that explains the value proposition in plain, honest terms.</p>
  <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;">
    <a href="#" style="display:inline-block;padding:.7rem 1.6rem;background:#fff;color:#2563eb;border-radius:8px;font-weight:700;text-decoration:none;font-size:.95rem;">Get started</a>
    <a href="#" style="display:inline-block;padding:.7rem 1.6rem;border:2px solid rgba(255,255,255,.4);color:#fff;border-radius:8px;font-weight:700;text-decoration:none;font-size:.95rem;">Learn more</a>
  </div>
</section>`,
  };

  // ── Init ──
  editor.addEventListener('input', onEditorInput);
  editor.addEventListener('scroll', syncScroll);
  editor.addEventListener('keydown', onKeyDown);

  function onEditorInput() {
    updateLineNumbers();
    updateMeta();
    if (document.getElementById('auto-preview').checked) {
      clearTimeout(previewTimer);
      previewTimer = setTimeout(renderPreview, 300);
    }
  }

  function onKeyDown(e) {
    // Tab → 2 spaces
    if (e.key === 'Tab') {
      e.preventDefault();
      const start = editor.selectionStart;
      const end   = editor.selectionEnd;
      editor.value = editor.value.substring(0, start) + '  ' + editor.value.substring(end);
      editor.selectionStart = editor.selectionEnd = start + 2;
      onEditorInput();
    }
  }

  function syncScroll() {
    lineNums.scrollTop = editor.scrollTop;
  }

  function updateLineNumbers() {
    const lines = (editor.value.match(/\n/g) || []).length + 1;
    const current = lineNums.children.length;
    if (lines > current) {
      const frag = document.createDocumentFragment();
      for (let i = current + 1; i <= lines; i++) {
        const d = document.createElement('div');
        d.textContent = i;
        frag.appendChild(d);
      }
      lineNums.appendChild(frag);
    } else if (lines < current) {
      while (lineNums.children.length > lines) lineNums.removeChild(lineNums.lastChild);
    }
  }

  function updateMeta() {
    const v     = editor.value;
    const lines = v ? v.split('\n').length : 0;
    document.getElementById('editor-meta').textContent =
      `${lines.toLocaleString()} line${lines !== 1 ? 's' : ''} · ${v.length.toLocaleString()} chars`;
    document.getElementById('editor-status').textContent = v.trim() ? 'Editing…' : 'Ready';
    emptyState.style.opacity = v.trim() ? '0' : '1';
    emptyState.style.pointerEvents = v.trim() ? 'none' : 'auto';
  }

  // ── Render preview ──
  function renderPreview() {
    const html = editor.value;
    if (!html.trim()) {
      frame.srcdoc = '';
      document.getElementById('preview-status').textContent = 'Waiting for input…';
      document.getElementById('preview-size').textContent = '';
      return;
    }

    // Inject dark background if needed
    const doc = previewTheme === 'dark'
      ? html.replace(/<body/i, '<body style="background:#111827;color:#f9fafb;"')
      : html;

    lastHtml = html;
    frame.srcdoc = doc;

    const bytes = new TextEncoder().encode(html).length;
    document.getElementById('preview-status').textContent = 'Rendered';
    document.getElementById('preview-size').textContent = formatBytes(bytes);
  }

  // ── Toolbar buttons ──
  document.getElementById('btn-sample').addEventListener('click', () => {
    editor.value = SAMPLE_HTML;
    onEditorInput();
    renderPreview();
  });

  document.getElementById('btn-paste-editor').addEventListener('click', async () => {
    try {
      const text = await navigator.clipboard.readText();
      insertAtCursor(text);
    } catch(_) {}
  });

  document.getElementById('btn-format').addEventListener('click', () => {
    try {
      const formatted = formatHtml(editor.value);
      editor.value = formatted;
      onEditorInput();
    } catch(_) {
      document.getElementById('editor-status').textContent = 'Could not format';
    }
  });

  document.getElementById('btn-clear-editor').addEventListener('click', () => {
    editor.value = '';
    onEditorInput();
    frame.srcdoc = '';
    document.getElementById('preview-status').textContent = 'Waiting for input…';
    document.getElementById('preview-size').textContent = '';
  });

  document.getElementById('btn-refresh').addEventListener('click', renderPreview);

  document.getElementById('btn-theme-toggle').addEventListener('click', () => {
    previewTheme = previewTheme === 'light' ? 'dark' : 'light';
    document.getElementById('icon-dark').classList.toggle('hidden', previewTheme === 'dark');
    document.getElementById('icon-light').classList.toggle('hidden', previewTheme === 'light');
    renderPreview();
  });

  document.getElementById('btn-open-new').addEventListener('click', () => {
    const html = editor.value || '<p>No HTML yet.</p>';
    const win  = window.open('', '_blank');
    if (win) { win.document.write(html); win.document.close(); }
  });

  document.getElementById('btn-download-html').addEventListener('click', () => {
    const html = editor.value;
    if (!html.trim()) return;
    const blob = new Blob([html], { type: 'text/html;charset=utf-8' });
    const a    = document.createElement('a');
    a.href     = URL.createObjectURL(blob);
    a.download = 'preview.html';
    a.click();
    URL.revokeObjectURL(a.href);
  });

  document.getElementById('btn-copy-html').addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(editor.value);
      const btn = document.getElementById('btn-copy-html');
      btn.style.color = 'oklch(67% 0.18 162)';
      setTimeout(() => { btn.style.color = ''; }, 1500);
    } catch(_) {}
  });

  // ── Viewport switcher ──
  document.querySelectorAll('.vp-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.vp-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const vp = btn.dataset.vp;
      frame.className = 'border-0 transition-all duration-300 bg-white';
      const wrap = document.getElementById('preview-frame-wrap');

      if (vp === 'desktop') {
        frame.style.maxWidth = '';
        frame.style.borderRadius = '';
        wrap.style.padding = '0';
      } else if (vp === 'tablet') {
        frame.className += ' vp-tablet';
        frame.style.maxWidth = '768px';
        frame.style.borderRadius = '';
        wrap.style.padding = '16px';
      } else {
        frame.className += ' vp-mobile';
        frame.style.maxWidth = '390px';
        frame.style.borderRadius = '16px';
        wrap.style.padding = '24px';
      }

      // Force re-render to keep content
      renderPreview();
    });
  });

  // ── Auto-preview toggle ──
  document.getElementById('auto-preview').addEventListener('change', function () {
    if (this.checked) renderPreview();
  });

  // ── Snippets ──
  Object.keys(SNIPPETS).forEach(id => {
    const btn = document.getElementById(id);
    if (btn) btn.addEventListener('click', () => { insertAtCursor(SNIPPETS[id]); });
  });

  // ── Helpers ──
  function insertAtCursor(text) {
    const start = editor.selectionStart;
    const end   = editor.selectionEnd;
    editor.value = editor.value.substring(0, start) + text + editor.value.substring(end);
    editor.selectionStart = editor.selectionEnd = start + text.length;
    editor.focus();
    onEditorInput();
    if (document.getElementById('auto-preview').checked) renderPreview();
  }

  function formatHtml(html) {
    // Basic pretty-printer: indent after opening tags, unindent before closing tags
    let indent = 0;
    const INDENT = '  ';
    const INLINE = /^(a|abbr|acronym|b|bdo|big|br|button|cite|code|dfn|em|i|img|input|kbd|label|map|object|output|q|s|samp|select|small|span|strong|sub|sup|textarea|time|tt|u|var)$/i;

    return html
      .replace(/>\s*</g, '>\n<')
      .split('\n')
      .map(line => line.trim())
      .filter(line => line.length > 0)
      .map(line => {
        const isClosing  = /^<\//.test(line);
        const isSelfClose = /\/>$/.test(line) || /^<(area|base|br|col|embed|hr|img|input|link|meta|param|source|track|wbr)/i.test(line);
        const tagMatch   = line.match(/^<([a-z][a-z0-9]*)/i);
        const tag        = tagMatch ? tagMatch[1] : null;
        const isInline   = tag && INLINE.test(tag);

        if (isClosing && !isInline) indent = Math.max(0, indent - 1);
        const result = INDENT.repeat(indent) + line;
        if (!isClosing && !isSelfClose && tag && !isInline) indent++;
        return result;
      })
      .join('\n');
  }

  function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  // FAQ accordion
  document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const body   = btn.nextElementSibling;
      const icon   = btn.querySelector('.faq-icon');
      const isOpen = !body.classList.contains('hidden');
      document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
      document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');
      if (!isOpen) { body.classList.remove('hidden'); icon.style.transform = 'rotate(180deg)'; }
    });
  });

  // Load sample on first visit
  editor.value = SAMPLE_HTML;
  onEditorInput();
  renderPreview();

});
</script>
@endpush

@endsection
