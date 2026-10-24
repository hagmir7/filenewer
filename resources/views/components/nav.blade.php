<nav id="site-nav" class="sticky top-0 z-50 border-b border-white/[0.07] backdrop-blur-xl bg-fn-bg/85">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="/">
            <img src="/filenewer-logo.svg" alt="The Fastest Online File Tools " width="100" height="50"
                class="h-[40px] w-auto md:h-[57px]">
        </a>

        <!-- Desktop Links -->
        <ul class="hidden lg:flex items-center gap-8 list-none">
            <li><a href="/#features"
                    class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Features</a></li>
            <li><a href="/tools"
                    class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Tools</a></li>
            <li><a href="/#security"
                    class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Security</a></li>
            <li><a href="/blog" class="text-fn-text2 text-sm font-medium hover:text-fn-text transition-colors">Blog</a>
            </li>
        </ul>

        <!-- CTAs -->
        <div class="flex items-center gap-3">
            @if (auth()->user())

            <a href="{{ route('logout') }}"
                class="inline-flex items-center gap-2 px-2 md:px-4 py-1 md:py-2 text-sm md:text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-red hover:border-fn-red/30 hover:bg-fn-red/5 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Logout</span>
            </a>

            @else

            <a href="/login"
                class="hidden sm:inline-flex items-center px-2 md:px-4 py-1.5 md:py-2 text-sm md:text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                Sign In
            </a>

            @endif

            <!-- Hamburger (mobile + tablet only) -->
            <button type="button" id="menu-toggle" aria-expanded="false" aria-controls="mobile-menu"
                aria-label="Toggle menu"
                class="lg:hidden inline-flex items-center justify-center w-10 h-10 text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface transition-all">
                <svg id="icon-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6" />
                    <line x1="4" y1="12" x2="20" y2="12" />
                    <line x1="4" y1="18" x2="20" y2="18" />
                </svg>
                <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="6" y1="6" x2="18" y2="18" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Dropdown (mobile + tablet only) -->
    <div id="mobile-menu" class="lg:hidden absolute inset-x-0 top-full origin-top border-b border-white/[0.07] bg-fn-bg/95 backdrop-blur-xl shadow-xl shadow-black/30
               transition-all duration-200 ease-out opacity-0 -translate-y-2 scale-95 invisible pointer-events-none">
        <ul class="max-w-6xl mx-auto px-6 py-4 flex flex-col list-none">
            <li><a href="/#features"
                    class="block py-3 text-fn-text2 text-base font-medium hover:text-fn-text transition-colors">Features</a>
            </li>
            <li><a href="/tools"
                    class="block py-3 text-fn-text2 text-base font-medium hover:text-fn-text transition-colors">Tools</a>
            </li>
            <li><a href="/#security"
                    class="block py-3 text-fn-text2 text-base font-medium hover:text-fn-text transition-colors">Security</a>
            </li>
            <li><a href="/blog"
                    class="block py-3 text-fn-text2 text-base font-medium hover:text-fn-text transition-colors">Blog</a>
            </li>

            @guest
            <li class="sm:hidden mt-2 pt-4 border-t border-white/[0.07]">
                <a href="/login"
                    class="block text-center px-4 py-2.5 text-sm font-semibold text-fn-text2 border border-white/[0.07] rounded-lg hover:text-fn-text hover:bg-fn-surface hover:border-white/[0.15] transition-all">
                    Sign In
                </a>
            </li>
            @endguest
        </ul>
    </div>
</nav>

<script>
    (function () {
        var nav = document.getElementById('site-nav');
        var btn = document.getElementById('menu-toggle');
        var menu = document.getElementById('mobile-menu');
        var iconOpen = document.getElementById('icon-open');
        var iconClose = document.getElementById('icon-close');

        var hiddenClasses = ['opacity-0', '-translate-y-2', 'scale-95', 'invisible', 'pointer-events-none'];
        var shownClasses = ['opacity-100', 'translate-y-0', 'scale-100'];

        function setMenu(open) {
            hiddenClasses.forEach(function (c) { menu.classList.toggle(c, !open); });
            shownClasses.forEach(function (c) { menu.classList.toggle(c, open); });
            iconOpen.classList.toggle('hidden', open);
            iconClose.classList.toggle('hidden', !open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        function isOpen() {
            return btn.getAttribute('aria-expanded') === 'true';
        }

        // Toggle on button click
        btn.addEventListener('click', function () { setMenu(!isOpen()); });

        // Close when a menu link is clicked
        menu.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () { setMenu(false); });
        });

        // Close on outside click
        document.addEventListener('click', function (e) {
            if (isOpen() && !nav.contains(e.target)) setMenu(false);
        });

        // Close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setMenu(false);
        });

        // Close when resizing to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) setMenu(false);
        });
    })();
</script>
