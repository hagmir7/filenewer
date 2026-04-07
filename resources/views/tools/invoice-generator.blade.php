@extends('layouts.base')

@section('content')

<x-tool-hero :tool="$tool" />

<!-- ══════════════════════ TOOL ══════════════════════ -->
<section id="tool" class="py-16 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="tool-heading">
    <div class="max-w-7xl mx-auto px-6">
        <h2 id="tool-heading" class="sr-only">Invoice PDF Generator Tool</h2>

        <div class="grid xl:grid-cols-[1fr_480px] gap-8 items-start">

            <!-- ── LEFT: Form ── -->
            <div class="flex flex-col gap-6">

                <!-- ─ Header Row: Invoice Meta ─ -->
                <div class="bg-fn-bg border border-white/[0.07] rounded-2xl p-7">
                    <h3 class="text-sm font-semibold text-fn-blue-l uppercase tracking-widest mb-5">Invoice Details</h3>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-fn-text3 text-sm font-medium">Invoice Number</label>
                            <input id="inv-number" type="text" value="INV-0001" class="fn-input" />
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-fn-text3 text-sm font-medium">Issue Date</label>
                            <input id="inv-date" type="date" class="fn-input" />
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-fn-text3 text-sm font-medium">Due Date</label>
                            <input id="inv-due" type="date" class="fn-input" />
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-fn-text3 text-sm font-medium">Currency</label>
                            <select id="inv-currency" class="fn-input cursor-pointer">
                                <option value="USD">USD — US Dollar ($)</option>
                                <option value="EUR">EUR — Euro (€)</option>
                                <option value="GBP">GBP — British Pound (£)</option>
                                <option value="CAD">CAD — Canadian Dollar (CA$)</option>
                                <option value="AUD">AUD — Australian Dollar (A$)</option>
                                <option value="JPY">JPY — Japanese Yen (¥)</option>
                                <option value="MAD">MAD — Moroccan Dirham (د.م.)</option>
                                <option value="AED">AED — UAE Dirham (د.إ)</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-fn-text3 text-sm font-medium">Accent Color</label>
                            <div class="flex items-center gap-2">
                                <input id="inv-color" type="color" value="#2563eb"
                                    class="w-9 h-9 rounded-lg border border-white/[0.07] bg-fn-surface cursor-pointer p-0.5" />
                                <span id="inv-color-hex" class="text-fn-text3 text-sm font-mono">#2563eb</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-fn-text3 text-sm font-medium">Logo URL <span
                                    class="text-fn-text3/50">(optional)</span></label>
                            <input id="inv-logo" type="url" placeholder="https://yoursite.com/logo.png"
                                class="fn-input" />
                        </div>
                    </div>
                </div>

                <!-- ─ From / To ─ -->
                <div class="grid sm:grid-cols-2 gap-6">

                    <div class="bg-fn-bg border border-white/[0.07] rounded-2xl p-7">
                        <h3 class="text-sm font-semibold text-fn-blue-l uppercase tracking-widest mb-5">From (Your
                            Business)</h3>
                        <div class="flex flex-col gap-3">
                            <input id="from-name" type="text" placeholder="Business Name" class="fn-input" />
                            <input id="from-email" type="email" placeholder="email@company.com" class="fn-input" />
                            <input id="from-address" type="text" placeholder="Street Address" class="fn-input" />
                            <div class="grid grid-cols-2 gap-3">
                                <input id="from-city" type="text" placeholder="City" class="fn-input" />
                                <input id="from-zip" type="text" placeholder="ZIP / Post" class="fn-input" />
                            </div>
                            <input id="from-country" type="text" placeholder="Country" class="fn-input" />
                            <input id="from-tax-id" type="text" placeholder="Tax ID / VAT No." class="fn-input" />
                        </div>
                    </div>

                    <div class="bg-fn-bg border border-white/[0.07] rounded-2xl p-7">
                        <h3 class="text-sm font-semibold text-fn-cyan uppercase tracking-widest mb-5">Bill To (Client)
                        </h3>
                        <div class="flex flex-col gap-3">
                            <input id="to-name" type="text" placeholder="Client Name / Company" class="fn-input" />
                            <input id="to-email" type="email" placeholder="client@email.com" class="fn-input" />
                            <input id="to-address" type="text" placeholder="Street Address" class="fn-input" />
                            <div class="grid grid-cols-2 gap-3">
                                <input id="to-city" type="text" placeholder="City" class="fn-input" />
                                <input id="to-zip" type="text" placeholder="ZIP / Post" class="fn-input" />
                            </div>
                            <input id="to-country" type="text" placeholder="Country" class="fn-input" />
                            <input id="to-tax-id" type="text" placeholder="Tax ID / VAT No." class="fn-input" />
                        </div>
                    </div>

                </div>

                <!-- ─ Line Items ─ -->
                <div class="bg-fn-bg border border-white/[0.07] rounded-2xl p-7">
                    <h3 class="text-sm font-semibold text-fn-blue-l uppercase tracking-widest mb-5">Line Items</h3>

                    <!-- Table header -->
                    <div class="hidden sm:grid grid-cols-[1fr_80px_100px_100px_36px] gap-3 mb-2 px-1">
                        <span class="text-fn-text3 text-sm font-medium">Description</span>
                        <span class="text-fn-text3 text-sm font-medium text-center">Qty</span>
                        <span class="text-fn-text3 text-sm font-medium text-right">Unit Price</span>
                        <span class="text-fn-text3 text-sm font-medium text-right">Total</span>
                        <span></span>
                    </div>

                    <div id="line-items" class="flex flex-col gap-2"></div>

                    <button id="add-line-btn"
                        class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-dashed border-white/[0.12] rounded-xl text-fn-text3 text-sm font-medium hover:border-fn-blue/40 hover:text-fn-blue-l transition-all">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Add Line Item
                    </button>
                </div>

                <!-- ─ Totals & Settings ─ -->
                <div class="grid sm:grid-cols-2 gap-6">

                    <div class="bg-fn-bg border border-white/[0.07] rounded-2xl p-7">
                        <h3 class="text-sm font-semibold text-fn-blue-l uppercase tracking-widest mb-5">Tax &amp;
                            Discount</h3>
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-fn-text3 text-sm font-medium">Discount (%)</label>
                                <input id="inv-discount" type="number" min="0" max="100" step="0.01" value="0"
                                    class="fn-input" />
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-fn-text3 text-sm font-medium">Tax / VAT (%)</label>
                                <input id="inv-tax" type="number" min="0" max="100" step="0.01" value="0"
                                    class="fn-input" />
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-fn-text3 text-sm font-medium">Shipping / Handling</label>
                                <input id="inv-shipping" type="number" min="0" step="0.01" value="0" class="fn-input" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-fn-bg border border-white/[0.07] rounded-2xl p-7">
                        <h3 class="text-sm font-semibold text-fn-blue-l uppercase tracking-widest mb-5">Payment &amp;
                            Notes</h3>
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-fn-text3 text-sm font-medium">Payment Terms</label>
                                <select id="inv-terms" class="fn-input cursor-pointer">
                                    <option>Due on Receipt</option>
                                    <option>Net 7</option>
                                    <option selected>Net 15</option>
                                    <option>Net 30</option>
                                    <option>Net 60</option>
                                    <option>Custom</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-fn-text3 text-sm font-medium">Notes / Bank Details</label>
                                <textarea id="inv-notes" rows="3"
                                    placeholder="Payment instructions, bank details, thank-you note..."
                                    class="fn-input resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ─ Download Bar ─ -->
                <div
                    class="flex flex-wrap items-center justify-between gap-4 bg-fn-bg border border-white/[0.07] rounded-2xl px-7 py-5">
                    <div class="flex items-center gap-4">
                        <div id="total-display" class="text-2xl font-bold text-fn-text tracking-tight">$0.00</div>
                        <span class="text-fn-text3 text-sm">Total Amount Due</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="preview-btn"
                            class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            Preview
                        </button>
                        <button id="download-btn"
                            class="inline-flex items-center gap-2 px-7 py-3 text-sm font-semibold text-white bg-fn-blue rounded-xl hover:bg-fn-blue-l btn-glow hover:-translate-y-0.5 transition-all">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg>
                            Download PDF
                        </button>
                    </div>
                </div>

            </div>

            <!-- ── RIGHT: Live Preview ── -->
            <div class="xl:sticky xl:top-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-fn-text3 text-sm font-mono uppercase tracking-widest">Live Preview</span>
                    <span class="text-fn-text3 text-sm">A4 · PDF</span>
                </div>
                <!-- Preview shell -->
                <div class="bg-fn-bg border border-white/[0.07] rounded-2xl overflow-hidden shadow-2xl">
                    <div class="flex items-center gap-2 px-4 py-2.5 border-b border-white/[0.07]">
                        <span class="w-2.5 h-2.5 rounded-full bg-fn-red"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-fn-amber"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-fn-green"></span>
                        <span class="text-fn-text3 text-sm font-mono ml-auto"
                            id="preview-filename">invoice-INV-0001.pdf</span>
                    </div>
                    <!-- Scaled A4 preview -->
                    <div class="p-4 bg-fn-surface2 overflow-auto max-h-[780px]">
                        <div id="invoice-preview-wrap" class="origin-top-left"
                            style="transform: scale(0.62); width: 161.3%; transform-origin: top left;">
                            <div id="invoice-preview" class="bg-white shadow-xl"
                                style="width:794px; min-height:1123px; font-family:'Helvetica Neue',Helvetica,Arial,sans-serif; color:#1a1a2e;">
                                <!-- Rendered by JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ HOW IT WORKS ══════════════════════ -->
<section id="how" class="py-24 bg-fn-bg" aria-labelledby="how-heading">
    <div class="max-w-6xl mx-auto px-6">

        <div class="text-center mb-16">
            <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Simple Process</p>
            <h2 id="how-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">From blank to sent in
                minutes</h2>
            <p class="text-fn-text2 text-lg max-w-lg mx-auto leading-relaxed">No design skills, no accounting software.
                Just fill in the form and you're done.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-px border border-white/[0.07] rounded-2xl overflow-hidden">

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">01</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-blue/10 border border-fn-blue/25">
                    ✏️</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Fill In Your Details</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Enter your business info, client details, invoice
                    number, and due date. Add your logo URL for branded output.</p>
            </div>

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">02</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-cyan/10 border border-fn-cyan/25">
                    📋</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Add Line Items</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">List your services or products with quantities and unit
                    prices. Apply discounts, tax, and shipping — totals calculate live.</p>
            </div>

            <div class="bg-fn-surface2 p-10 hover:bg-fn-surface3 transition-colors relative">
                <div class="absolute top-10 right-10 text-fn-text3/10 text-6xl font-bold font-mono select-none">03</div>
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-6 bg-fn-green/10 border border-fn-green/25">
                    📩</div>
                <h3 class="text-lg font-semibold tracking-tight mb-2.5">Download &amp; Send</h3>
                <p class="text-fn-text2 text-sm leading-relaxed">Click Download PDF to get a clean, professional invoice
                    file. Attach it directly to your email and get paid faster.</p>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ FEATURES ══════════════════════ -->
<section id="features" class="py-24 bg-fn-surface border-y border-white/[0.07]" aria-labelledby="features-heading">
    <div class="max-w-6xl mx-auto px-6">

        <div class="mb-16">
            <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">What's Included</p>
            <h2 id="features-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Everything a freelancer
                or small business needs</h2>
            <p class="text-fn-text2 text-lg max-w-lg leading-relaxed">No subscriptions. No exports locked behind
                paywalls. Just the tool.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">👁️</div>
                <h3 class="font-semibold text-base mb-2">Live Preview</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">See your invoice update in real-time as you type. What
                    you see in the preview is exactly what gets exported to PDF.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🎨</div>
                <h3 class="font-semibold text-base mb-2">Custom Branding</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Set your brand color and add a logo URL. Your invoice
                    header will match your company's visual identity perfectly.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">💱</div>
                <h3 class="font-semibold text-base mb-2">8 Currencies</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Invoice in USD, EUR, GBP, CAD, AUD, JPY, MAD, or AED.
                    Currency symbol is applied throughout the document automatically.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🧮</div>
                <h3 class="font-semibold text-base mb-2">Auto Calculations</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Subtotal, discount, tax/VAT, shipping, and grand total
                    are all computed automatically as you add or update items.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">📝</div>
                <h3 class="font-semibold text-base mb-2">Notes &amp; Terms</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Add payment instructions, bank account details, or a
                    thank-you note. Fully supports NET 7, NET 30, and custom terms.</p>
            </div>

            <div
                class="p-7 bg-fn-bg border border-white/[0.07] rounded-xl hover:border-fn-blue/30 hover:-translate-y-1 transition-all">
                <div class="text-3xl mb-4">🔒</div>
                <h3 class="font-semibold text-base mb-2">100% Private</h3>
                <p class="text-fn-text3 text-sm leading-relaxed">Invoice data never leaves your browser. The PDF is
                    generated client-side — no server, no storage, no data exposure.</p>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════ FAQ ══════════════════════ -->
<section id="faq" class="py-24 bg-fn-bg" aria-labelledby="faq-heading">
    <div class="max-w-3xl mx-auto px-6">

        <div class="text-center mb-16">
            <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">FAQ</p>
            <h2 id="faq-heading" class="text-3xl sm:text-4xl font-bold tracking-tight mb-4">Common questions</h2>
        </div>

        <div class="flex flex-col gap-3">

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Is this invoice generator really free?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">Yes, completely. No watermarks, no sign-up,
                    no credit card. The core invoice generator is permanently free. A Pro plan is available for saved
                    templates and invoice history.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Is the generated PDF legally valid?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">The PDF contains all standard invoice fields
                    required in most jurisdictions — invoice number, dates, party details, itemized amounts, and tax.
                    However, tax law varies by country; consult an accountant for jurisdiction-specific compliance
                    requirements.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Does my invoice data get saved to your servers?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">No. All invoice generation happens entirely
                    in your browser. Your client names, amounts, and business details never touch our servers. The PDF
                    is created and downloaded locally.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    Can I add my company logo?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">Yes. Enter a publicly accessible image URL in
                    the Logo URL field and it will appear in the top-left of your invoice. PNG and JPG formats work
                    best. For file uploads (no public URL needed), upgrade to Pro.</p>
            </details>

            <details class="group bg-fn-surface border border-white/[0.07] rounded-xl overflow-hidden">
                <summary
                    class="flex items-center justify-between px-6 py-5 cursor-pointer font-semibold text-sm text-fn-text select-none list-none">
                    How do I add multiple tax rates?
                    <svg class="w-4 h-4 text-fn-text3 group-open:rotate-180 transition-transform flex-shrink-0"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </summary>
                <p class="px-6 pb-5 text-fn-text2 text-sm leading-relaxed">The free tool supports a single tax rate
                    applied to the subtotal. For line-item-level tax rates or multiple tax types (e.g., GST + PST), this
                    is available as a Pro feature.</p>
            </details>

        </div>
    </div>
</section>

<!-- ══════════════════════ RELATED TOOLS ══════════════════════ -->
<x-tools-section />

<!-- ══════════════════════ CTA ══════════════════════ -->
<section id="cta" class="py-24 bg-fn-surface border-y border-white/[0.07] text-center relative overflow-hidden"
    aria-labelledby="cta-heading">
    <div
        class="absolute top-[-300px] left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-[radial-gradient(ellipse_at_center,rgba(37,99,235,0.14)_0%,transparent_65%)] pointer-events-none">
    </div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <p class="text-fn-blue-l text-sm font-semibold uppercase tracking-widest mb-3">Upgrade for More</p>
        <h2 id="cta-heading" class="text-3xl sm:text-4xl font-bold tracking-tight max-w-2xl mx-auto mb-4">Save
            templates, track invoices, and automate your billing</h2>
        <p class="text-fn-text2 text-lg max-w-md mx-auto leading-relaxed mb-10">
            Join thousands of freelancers and small businesses who use Filenewer Pro to manage their invoicing workflow
            end-to-end.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="/signup"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-white bg-fn-blue rounded-xl hover:bg-fn-blue-l btn-glow hover:-translate-y-0.5 transition-all">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" />
                </svg>
                Start Free — No Sign-up Needed
            </a>
            <a href="/pricing"
                class="inline-flex items-center gap-2 px-7 py-3.5 text-base font-semibold text-fn-text2 border border-white/[0.07] rounded-xl hover:text-fn-text hover:bg-fn-surface2 hover:border-white/[0.15] transition-all">
                View Pro Plans
            </a>
        </div>
        <p class="text-fn-text3 text-sm mt-5">✓ Free forever &nbsp;·&nbsp; ✓ No watermarks &nbsp;·&nbsp; ✓ No account
            needed</p>
    </div>
</section>

<!-- ══════════════════════ STYLES ══════════════════════ -->
@push('styles')
<style>
    .fn-input {
        background: var(--fn-surface, #111827);
        border: 1px solid rgba(255, 255, 255, 0.07);
        color: var(--fn-text2, #d1d5db);
        font-size: 0.75rem;
        line-height: 1.5;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        outline: none;
        transition: border-color 0.15s;
        width: 100%;
    }

    .fn-input:focus {
        border-color: rgba(37, 99, 235, 0.5);
    }

    .fn-input::placeholder {
        color: rgba(156, 163, 175, 0.4);
    }

    .fn-input option {
        background: #1f2937;
        color: #d1d5db;
    }
</style>
@endpush

<!-- ══════════════════════ SCRIPT ══════════════════════ -->
@push('scripts')
{{-- jsPDF for client-side PDF generation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

<script>
    (function () {

    // ── Currency map ──────────────────────────────────────────
    const CURRENCIES = {
        USD: { sym: '$',    code: 'USD' },
        EUR: { sym: '€',    code: 'EUR' },
        GBP: { sym: '£',    code: 'GBP' },
        CAD: { sym: 'CA$',  code: 'CAD' },
        AUD: { sym: 'A$',   code: 'AUD' },
        JPY: { sym: '¥',    code: 'JPY' },
        MAD: { sym: 'د.م.', code: 'MAD' },
        AED: { sym: 'د.إ',  code: 'AED' },
    };

    // ── State ─────────────────────────────────────────────────
    let lineItems = [];
    let lineCounter = 0;

    // ── DOM helpers ───────────────────────────────────────────
    const $  = (id) => document.getElementById(id);
    const gv = (id) => $(id) ? $(id).value.trim() : '';

    // ── Set today / +30 days as defaults ─────────────────────
    const pad = (n) => String(n).padStart(2,'0');
    const today = new Date();
    const due   = new Date(today); due.setDate(due.getDate() + 30);
    const fmt   = (d) => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
    $('inv-date').value = fmt(today);
    $('inv-due').value  = fmt(due);

    // ── Line item ─────────────────────────────────────────────
    function addLine(desc='', qty=1, price=0) {
        const id = ++lineCounter;
        lineItems.push({ id, desc, qty, price });
        renderLines();
    }

    function renderLines() {
        const container = $('line-items');
        container.innerHTML = '';
        lineItems.forEach((item) => {
            const row = document.createElement('div');
            row.className = 'grid grid-cols-[1fr_80px_100px_100px_36px] gap-3 items-center';
            row.dataset.id = item.id;
            row.innerHTML = `
                <input type="text" value="${escAttr(item.desc)}" placeholder="Service or product description"
                    class="fn-input" data-field="desc" data-id="${item.id}" />
                <input type="number" value="${item.qty}" min="0" step="0.01"
                    class="fn-input text-center" data-field="qty" data-id="${item.id}" />
                <input type="number" value="${item.price}" min="0" step="0.01"
                    class="fn-input text-right" data-field="price" data-id="${item.id}" />
                <div class="text-fn-text2 text-sm font-mono text-right py-2 px-1 line-total" data-id="${item.id}">
                    ${fmtMoney(item.qty * item.price)}
                </div>
                <button class="remove-line w-8 h-8 flex items-center justify-center rounded-lg text-fn-text3 hover:text-fn-red hover:bg-fn-red/10 transition-all" data-id="${item.id}">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            `;
            container.appendChild(row);
        });
        updateTotals();
    }

    function escAttr(s) {
        return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    // ── Currency / formatting ─────────────────────────────────
    function getCurrency() { return CURRENCIES[gv('inv-currency')] || CURRENCIES.USD; }

    function fmtMoney(n) {
        const c = getCurrency();
        const num = parseFloat(n) || 0;
        const dec = c.code === 'JPY' ? 0 : 2;
        return c.sym + num.toFixed(dec).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    // ── Totals ────────────────────────────────────────────────
    function computeTotals() {
        const subtotal  = lineItems.reduce((s, i) => s + (parseFloat(i.qty)||0) * (parseFloat(i.price)||0), 0);
        const discPct   = parseFloat(gv('inv-discount')) || 0;
        const taxPct    = parseFloat(gv('inv-tax'))      || 0;
        const shipping  = parseFloat(gv('inv-shipping')) || 0;
        const discount  = subtotal * (discPct / 100);
        const afterDisc = subtotal - discount;
        const tax       = afterDisc * (taxPct / 100);
        const total     = afterDisc + tax + shipping;
        return { subtotal, discount, discPct, afterDisc, tax, taxPct, shipping, total };
    }

    function updateTotals() {
        const t = computeTotals();
        $('total-display').textContent = fmtMoney(t.total);
        renderPreview();
    }

    // ── Preview renderer ──────────────────────────────────────
    function renderPreview() {
        const t    = computeTotals();
        const c    = getCurrency();
        const col  = gv('inv-color') || '#2563eb';
        const logo = gv('inv-logo');
        const num  = gv('inv-number') || 'INV-0001';

        // Update filename
        $('preview-filename').textContent = `invoice-${num}.pdf`;

        const fromLines = [
            gv('from-name'), gv('from-email'),
            gv('from-address'),
            [gv('from-city'), gv('from-zip')].filter(Boolean).join(', '),
            gv('from-country'), gv('from-tax-id')
        ].filter(Boolean);

        const toLines = [
            gv('to-name'), gv('to-email'),
            gv('to-address'),
            [gv('to-city'), gv('to-zip')].filter(Boolean).join(', '),
            gv('to-country'), gv('to-tax-id')
        ].filter(Boolean);

        const itemRows = lineItems.map(i => {
            const qty   = parseFloat(i.qty)   || 0;
            const price = parseFloat(i.price) || 0;
            return `
            <tr style="border-bottom:1px solid #f3f4f6;">
                <td style="padding:10px 12px;font-size:12px;color:#374151;">${escHtml(i.desc || '—')}</td>
                <td style="padding:10px 12px;font-size:12px;color:#374151;text-align:center;">${qty}</td>
                <td style="padding:10px 12px;font-size:12px;color:#374151;text-align:right;">${fmtMoney(price)}</td>
                <td style="padding:10px 12px;font-size:12px;color:#374151;text-align:right;font-weight:600;">${fmtMoney(qty * price)}</td>
            </tr>`;
        }).join('');

        const summaryRows = [
            ['Subtotal', fmtMoney(t.subtotal)],
            ...(t.discPct  ? [`Discount (${t.discPct}%)`, `−${fmtMoney(t.discount)}`] : []),
            ...(t.taxPct   ? [`Tax / VAT (${t.taxPct}%)`, fmtMoney(t.tax)] : []),
            ...(t.shipping ? ['Shipping', fmtMoney(t.shipping)] : []),
        ].map(([label, val]) => `
            <tr>
                <td style="padding:5px 12px;font-size:12px;color:#6b7280;text-align:right;">${label}</td>
                <td style="padding:5px 12px;font-size:12px;color:#374151;text-align:right;">${val}</td>
            </tr>
        `).join('');

        const notes = gv('inv-notes');
        const terms = gv('inv-terms');

        $('invoice-preview').innerHTML = `
        <div style="padding:48px 52px;">

            <!-- Header -->
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:40px;">
                <div>
                    ${logo ? `<img src="${escAttr(logo)}" alt="Logo" style="max-height:56px;max-width:180px;object-fit:contain;margin-bottom:12px;" onerror="this.style.display='none'" />` : ''}
                    <div style="font-size:22px;font-weight:700;color:#111827;letter-spacing:-0.03em;">${escHtml(gv('from-name') || 'Your Business')}</div>
                    ${fromLines.slice(1).map(l => `<div style="font-size:11px;color:#6b7280;margin-top:3px;">${escHtml(l)}</div>`).join('')}
                </div>
                <div style="text-align:right;">
                    <div style="font-size:28px;font-weight:800;color:${col};letter-spacing:-0.04em;line-height:1;">INVOICE</div>
                    <div style="font-size:13px;font-weight:600;color:#374151;margin-top:6px;">${escHtml(num)}</div>
                    <div style="font-size:11px;color:#9ca3af;margin-top:8px;">Issued: <span style="color:#374151;">${formatDate(gv('inv-date'))}</span></div>
                    <div style="font-size:11px;color:#9ca3af;margin-top:3px;">Due: <span style="color:#374151;font-weight:600;">${formatDate(gv('inv-due'))}</span></div>
                    <div style="font-size:11px;color:#9ca3af;margin-top:3px;">Terms: <span style="color:#374151;">${escHtml(terms)}</span></div>
                </div>
            </div>

            <!-- Accent rule -->
            <div style="height:3px;background:${col};border-radius:2px;margin-bottom:32px;"></div>

            <!-- Bill To -->
            <div style="display:flex;gap:48px;margin-bottom:36px;">
                <div style="flex:1;">
                    <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#9ca3af;margin-bottom:10px;">Bill To</div>
                    ${toLines.map((l,i) => `<div style="font-size:${i===0?'13':'11'}px;font-weight:${i===0?'600':'400'};color:${i===0?'#111827':'#6b7280'};margin-bottom:3px;">${escHtml(l)}</div>`).join('') || '<div style="font-size:11px;color:#9ca3af;">—</div>'}
                </div>
            </div>

            <!-- Items table -->
            <table style="width:100%;border-collapse:collapse;margin-bottom:28px;">
                <thead>
                    <tr style="background:${col};">
                        <th style="padding:10px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#fff;text-align:left;border-radius:6px 0 0 6px;">Description</th>
                        <th style="padding:10px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#fff;text-align:center;">Qty</th>
                        <th style="padding:10px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#fff;text-align:right;">Unit Price</th>
                        <th style="padding:10px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#fff;text-align:right;border-radius:0 6px 6px 0;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    ${itemRows || `<tr><td colspan="4" style="padding:16px 12px;font-size:12px;color:#9ca3af;text-align:center;">No items added yet</td></tr>`}
                </tbody>
            </table>

            <!-- Totals -->
            <div style="display:flex;justify-content:flex-end;margin-bottom:36px;">
                <table style="min-width:260px;">
                    <tbody>${summaryRows}</tbody>
                    <tfoot>
                        <tr style="background:${col};border-radius:8px;">
                            <td style="padding:12px 16px;font-size:13px;font-weight:700;color:#fff;text-align:right;border-radius:6px 0 0 6px;">Total Due</td>
                            <td style="padding:12px 16px;font-size:15px;font-weight:800;color:#fff;text-align:right;border-radius:0 6px 6px 0;">${fmtMoney(t.total)}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Notes -->
            ${notes ? `
            <div style="border-top:1px solid #f3f4f6;padding-top:24px;margin-bottom:8px;">
                <div style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#9ca3af;margin-bottom:8px;">Notes &amp; Payment Details</div>
                <div style="font-size:11px;color:#6b7280;white-space:pre-line;line-height:1.6;">${escHtml(notes)}</div>
            </div>` : ''}

            <!-- Footer -->
            <div style="margin-top:40px;padding-top:20px;border-top:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
                <div style="font-size:10px;color:#d1d5db;">Generated with Filenewer · filenewer.com</div>
                <div style="font-size:10px;color:#d1d5db;">${escHtml(num)} · ${formatDate(gv('inv-date'))}</div>
            </div>

        </div>`;
    }

    function escHtml(s) {
        return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function formatDate(str) {
        if (!str) return '—';
        const [y,m,d] = str.split('-');
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return `${months[parseInt(m,10)-1]} ${parseInt(d,10)}, ${y}`;
    }

    // ── PDF download via jsPDF ────────────────────────────────
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ unit: 'pt', format: 'a4' });
        const col   = gv('inv-color') || '#2563eb';
        const num   = gv('inv-number') || 'INV-0001';
        const t     = computeTotals();
        const W     = doc.internal.pageSize.getWidth();

        // Helper to parse hex
        const hexToRgb = (hex) => {
            const r = parseInt(hex.slice(1,3),16);
            const g = parseInt(hex.slice(3,5),16);
            const b = parseInt(hex.slice(5,7),16);
            return [r,g,b];
        };
        const [cr,cg,cb] = hexToRgb(col);

        let y = 50;

        // From name
        doc.setFontSize(18); doc.setFont('helvetica','bold');
        doc.setTextColor(17,24,39);
        doc.text(gv('from-name') || 'Your Business', 50, y);

        // INVOICE label
        doc.setFontSize(24); doc.setTextColor(cr,cg,cb);
        doc.text('INVOICE', W - 50, y, { align: 'right' });
        y += 18;

        // From sub-lines
        doc.setFontSize(9); doc.setFont('helvetica','normal'); doc.setTextColor(107,114,128);
        const fromLines = [gv('from-email'),gv('from-address'),[gv('from-city'),gv('from-zip')].filter(Boolean).join(', '),gv('from-country'),gv('from-tax-id')].filter(Boolean);
        fromLines.forEach(l => { doc.text(l, 50, y); y += 13; });

        // Invoice meta (right)
        doc.setFontSize(9); doc.setTextColor(107,114,128);
        let ym = 68;
        doc.text(`#${num}`, W - 50, ym, { align: 'right' }); ym += 13;
        doc.text(`Issued: ${formatDate(gv('inv-date'))}`, W - 50, ym, { align: 'right' }); ym += 13;
        doc.text(`Due: ${formatDate(gv('inv-due'))}`, W - 50, ym, { align: 'right' }); ym += 13;
        doc.text(`Terms: ${gv('inv-terms')}`, W - 50, ym, { align: 'right' });

        y = Math.max(y, ym) + 16;

        // Accent rule
        doc.setFillColor(cr,cg,cb);
        doc.roundedRect(50, y, W - 100, 3, 1, 1, 'F');
        y += 20;

        // Bill To
        doc.setFontSize(8); doc.setFont('helvetica','bold'); doc.setTextColor(156,163,175);
        doc.text('BILL TO', 50, y); y += 12;
        const toLines = [gv('to-name'),gv('to-email'),gv('to-address'),[gv('to-city'),gv('to-zip')].filter(Boolean).join(', '),gv('to-country'),gv('to-tax-id')].filter(Boolean);
        toLines.forEach((l,i) => {
            doc.setFontSize(i===0?11:9);
            doc.setFont('helvetica', i===0?'bold':'normal');
            doc.setTextColor(i===0?17:107, i===0?24:114, i===0?39:128);
            doc.text(l, 50, y); y += (i===0?15:12);
        });
        y += 16;

        // Items table
        const tableData = lineItems.map(i => {
            const qty   = parseFloat(i.qty)   || 0;
            const price = parseFloat(i.price) || 0;
            return [i.desc || '—', String(qty), fmtMoney(price), fmtMoney(qty * price)];
        });

        doc.autoTable({
            startY: y,
            head: [['Description','Qty','Unit Price','Total']],
            body: tableData.length ? tableData : [['No items','','','']],
            margin: { left: 50, right: 50 },
            styles: { fontSize: 9, cellPadding: 7, textColor: [55,65,81] },
            headStyles: { fillColor: [cr,cg,cb], textColor: [255,255,255], fontStyle: 'bold', fontSize: 8 },
            columnStyles: { 1: { halign: 'center' }, 2: { halign: 'right' }, 3: { halign: 'right', fontStyle: 'bold' } },
            alternateRowStyles: { fillColor: [249,250,251] },
        });

        y = doc.lastAutoTable.finalY + 20;

        // Totals block
        const summaryLines = [
            ['Subtotal', fmtMoney(t.subtotal)],
            ...(t.discPct  ? [[`Discount (${t.discPct}%)`, `−${fmtMoney(t.discount)}`]] : []),
            ...(t.taxPct   ? [[`Tax / VAT (${t.taxPct}%)`, fmtMoney(t.tax)]] : []),
            ...(t.shipping ? [['Shipping', fmtMoney(t.shipping)]] : []),
        ];
        const labelX = W - 200, valX = W - 50;
        summaryLines.forEach(([label, val]) => {
            doc.setFontSize(9); doc.setFont('helvetica','normal'); doc.setTextColor(107,114,128);
            doc.text(label, labelX, y);
            doc.setTextColor(55,65,81);
            doc.text(val, valX, y, { align: 'right' });
            y += 14;
        });
        y += 4;
        doc.setFillColor(cr,cg,cb);
        doc.roundedRect(W - 210, y - 6, 160, 22, 3, 3, 'F');
        doc.setFontSize(10); doc.setFont('helvetica','bold'); doc.setTextColor(255,255,255);
        doc.text('Total Due', W - 200, y + 9);
        doc.text(fmtMoney(t.total), valX, y + 9, { align: 'right' });
        y += 36;

        // Notes
        const notes = gv('inv-notes');
        if (notes) {
            doc.setDrawColor(243,244,246); doc.setLineWidth(0.5);
            doc.line(50, y, W - 50, y); y += 14;
            doc.setFontSize(8); doc.setFont('helvetica','bold'); doc.setTextColor(156,163,175);
            doc.text('NOTES & PAYMENT DETAILS', 50, y); y += 12;
            doc.setFont('helvetica','normal'); doc.setTextColor(107,114,128); doc.setFontSize(9);
            const noteLines = doc.splitTextToSize(notes, W - 100);
            doc.text(noteLines, 50, y); y += noteLines.length * 12 + 8;
        }

        // Footer
        const pageH = doc.internal.pageSize.getHeight();
        doc.setDrawColor(243,244,246); doc.line(50, pageH - 40, W - 50, pageH - 40);
        doc.setFontSize(8); doc.setFont('helvetica','normal'); doc.setTextColor(209,213,219);
        doc.text('Generated with Filenewer · filenewer.com', 50, pageH - 26);
        doc.text(`${num} · ${formatDate(gv('inv-date'))}`, W - 50, pageH - 26, { align: 'right' });

        doc.save(`invoice-${num}.pdf`);
    }

    // ── Event wiring ──────────────────────────────────────────
    // Add default line item
    addLine('Professional Services', 1, 0);

    $('add-line-btn').addEventListener('click', () => addLine());
    $('download-btn').addEventListener('click', downloadPDF);
    $('preview-btn').addEventListener('click', () => {
        $('invoice-preview').scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    // Line item events (delegated)
    $('line-items').addEventListener('input', (e) => {
        const id    = parseInt(e.target.dataset.id);
        const field = e.target.dataset.field;
        if (!id || !field) return;
        const item = lineItems.find(i => i.id === id);
        if (!item) return;
        item[field] = e.target.value;
        // Update row total display
        const qty   = parseFloat(item.qty)   || 0;
        const price = parseFloat(item.price) || 0;
        const totEl = $('line-items').querySelector(`.line-total[data-id="${id}"]`);
        if (totEl) totEl.textContent = fmtMoney(qty * price);
        updateTotals();
    });

    $('line-items').addEventListener('click', (e) => {
        const btn = e.target.closest('.remove-line');
        if (!btn) return;
        const id = parseInt(btn.dataset.id);
        lineItems = lineItems.filter(i => i.id !== id);
        renderLines();
        updateTotals();
    });

    // All form inputs trigger re-render
    const formIds = [
        'inv-number','inv-date','inv-due','inv-currency','inv-color','inv-logo',
        'from-name','from-email','from-address','from-city','from-zip','from-country','from-tax-id',
        'to-name','to-email','to-address','to-city','to-zip','to-country','to-tax-id',
        'inv-discount','inv-tax','inv-shipping','inv-terms','inv-notes'
    ];
    formIds.forEach(id => {
        const el = $(id);
        if (el) el.addEventListener('input', updateTotals);
        if (el && (el.tagName === 'SELECT')) el.addEventListener('change', updateTotals);
    });

    $('inv-color').addEventListener('input', (e) => {
        $('inv-color-hex').textContent = e.target.value;
        updateTotals();
    });

    // Initial render
    renderPreview();

})();
</script>
@endpush

@endsection
