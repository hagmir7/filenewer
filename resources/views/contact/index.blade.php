@extends('layouts.base')

@section('content')
<div class="min-h-screen flex">

    <!-- ══ LEFT PANEL — Branding ══ -->
    <div
        class="hidden lg:flex lg:w-[45%] xl:w-[42%] relative flex-col justify-between p-12 bg-fn-surface border-r border-fn-text/7 overflow-hidden panel-glow panel-glow-b grid-bg">

        <!-- Logo -->
        <a href="/" class="flex items-center gap-2.5 font-bold text-xl tracking-tight relative z-10">
            <div class="w-9 h-9 bg-fn-blue rounded-xl flex items-center justify-center shrink-0">
                📩
            </div>
            Filenewer
        </a>

        <!-- Center content -->
        <div class="relative z-10 space-y-10">
            <div>
                <p class="text-fn-cyan text-xs font-semibold uppercase tracking-widest mb-4">Contact Us</p>
                <h2 class="text-3xl xl:text-4xl font-bold tracking-tight leading-[1.15] mb-5">
                    Let’s start a<br />
                    conversation<span class="text-fn-text3">.</span>
                </h2>
                <p class="text-fn-text2 text-base leading-relaxed max-w-xs">
                    Have a question, feedback, or issue? Send us a message and we’ll get back to you quickly.
                </p>
            </div>

            <!-- Info -->
            <div class="space-y-3">
                <p class="text-xs font-semibold text-fn-text3 uppercase tracking-widest">Support</p>

                <div class="p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl text-md flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />
                    <path d="M3 7l9 6l9 -6" />
                </svg> <a href="mailto:support@filenewer.com">Support@filenewer.com</a>
                </div>

                <div class="p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl text-md flex gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-clock">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                        <path d="M12 7v5l3 3" />
                    </svg> <span>Response time: within 24h</span>
                </div>
            </div>

            <!-- Security -->
            <div class="flex items-center gap-3 p-4 bg-fn-green/5 border border-fn-green/15 rounded-xl">
                <p class="text-sm text-fn-text2 leading-relaxed">
                    Your messages are secure and encrypted.
                </p>
            </div>
        </div>

        <!-- Bottom -->
        <div class="relative z-10">
            <p class="text-fn-text3 text-sm font-medium italic">"We’re here to help."</p>
        </div>
    </div>

    <!-- ══ RIGHT PANEL — Contact Form ══ -->
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 relative overflow-hidden">

        <div class="w-full max-w-md">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight mb-1.5">Contact Us</h1>
                <p class="text-fn-text3 text-sm">Fill the form and we’ll reply soon</p>
            </div>

            <!-- Errors -->
            @if ($errors->any())
            <div class="mb-5 px-4 py-3 bg-fn-red/10 border border-fn-red/25 rounded-xl text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label class="text-xs font-semibold text-fn-text2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-sm"
                        placeholder="John Doe">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-xs font-semibold text-fn-text2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-sm"
                        placeholder="john@email.com">
                </div>

                <!-- Subject -->
                <div>
                    <label class="text-xs font-semibold text-fn-text2">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-sm"
                        placeholder="How can we help?">
                </div>

                <!-- Message -->
                <div>
                    <label class="text-xs font-semibold text-fn-text2">Message</label>
                    <textarea name="message" rows="5"
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border border-fn-text/10 rounded-xl text-sm"
                        placeholder="Write your message...">{{ old('message') }}</textarea>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full py-3 bg-fn-blue hover:bg-fn-blue-l text-white font-semibold text-sm rounded-xl transition">
                    Send Message
                </button>
            </form>

            <!-- Extra -->
            <p class="text-center text-xs text-fn-text3 mt-6">
                We usually respond within 24 hours.
            </p>

        </div>
    </div>
</div>
@endsection
