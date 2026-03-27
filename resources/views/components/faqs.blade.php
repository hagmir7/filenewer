<section class="py-16 border-t border-fn-text/7 bg-fn-surface">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-2xl font-bold tracking-tight mb-8 text-center">Frequently Asked Questions</h2>
        @php
        $faqs = [
        ['Is this really free?', 'Merging up to 20 PDFs (50MB each) is completely free with no account needed. Pro plans
        unlock larger files and batch operations.'],
        ['Can I change the order of my PDFs?', 'Yes — drag and drop the rows in the file list to set the exact order
        before you click Merge.'],
        ['Will my bookmarks and links be preserved?','Yes. Internal links and bookmarks are preserved from all source
        files. You can also add new per-file bookmarks automatically.'],
        ['Is my data safe?', 'All uploads use AES-256 encryption in transit and are permanently deleted within 1 hour.
        We never read, share, or store your content.'],
        ];
        @endphp
        <div class="space-y-3">
            @foreach($faqs as [$q, $a])
            <div class="border border-fn-text/8 rounded-xl overflow-hidden">
                <button type="button"
                    class="faq-btn w-full flex items-center justify-between px-5 py-4 text-left hover:bg-fn-surface2 transition-colors">
                    <span class="font-semibold text-sm">{{ $q }}</span>
                    <svg class="faq-icon w-4 h-4 text-fn-text3 shrink-0 transition-transform duration-200"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
                <div class="faq-body hidden px-5 pb-4">
                    <p class="text-fn-text2 text-sm leading-relaxed">{{ $a }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<script>
    // ── FAQ accordion ──
        document.querySelectorAll('.faq-btn').forEach(btn => {
        btn.addEventListener('click', () => {
        const body = btn.nextElementSibling;
        const icon = btn.querySelector('.faq-icon');
        const isOpen = !body.classList.contains('hidden');

        document.querySelectorAll('.faq-body').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');

        if (!isOpen) {
        body.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        }
        });
        });
</script>
