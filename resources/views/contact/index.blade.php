@extends('layouts.base')

@section('content')
<div class="min-h-screen flex">

    <!-- LEFT PANEL — Branding -->
    <div
        class="hidden lg:flex lg:w-[45%] xl:w-[42%] relative flex-col justify-between p-12 bg-fn-surface border-r border-fn-text/7 overflow-hidden panel-glow panel-glow-b grid-bg">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2.5 font-bold text-xl tracking-tight relative z-10">
            <div class="w-9 h-9 bg-fn-blue text-white rounded-xl flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M12 19H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7.5" />
                    <path d="m3 7 9 6 9-6" />
                    <path d="M19 16v6" />
                    <path d="m22 19-3 3-3-3" />
                </svg>
            </div>

            Filenewer
        </a>

        <!-- Center content -->
        <div class="relative z-10 space-y-10">
            <div>
                <p class="text-fn-cyan text-sm font-semibold uppercase tracking-widest mb-4">
                    Contact Us
                </p>

                <div class="text-3xl xl:text-4xl font-bold tracking-tight leading-[1.15] mb-5">
                    Let’s start a<br>
                    conversation<span class="text-fn-text3">.</span>
                </div>

                <p class="text-fn-text2 text-base leading-relaxed max-w-xs">
                    Have a question, feedback, or issue? Send us a message and we’ll get back to you quickly.
                </p>
            </div>

            <!-- Info -->
            <div class="space-y-3">
                <p class="text-sm font-semibold text-fn-text3 uppercase tracking-widest">
                    Support
                </p>

                <div class="p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl text-base flex gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7" />
                        <path d="m3 7 9 6 9-6" />
                    </svg>

                    <a href="mailto:contact@filenewer.com" class="break-all">
                        Contact@filenewer.com
                    </a>
                </div>

                <div class="p-3.5 bg-fn-surface2 border border-fn-text/7 rounded-xl text-base flex gap-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="shrink-0" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M12 7v5l3 3" />
                    </svg>

                    <span>Response time: within 24h</span>
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
            <p class="text-fn-text3 text-sm font-medium italic">
                "We’re here to help."
            </p>
        </div>
    </div>

    <!-- RIGHT PANEL — Contact Form -->
    <div
        class="flex-1 min-w-0 flex flex-col justify-center items-center px-4 sm:px-6 py-10 sm:py-12 relative overflow-hidden">
        <div class="w-full max-w-md">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold tracking-tight mb-1.5">
                    Contact Us
                </h1>

                <p class="text-fn-text3 text-sm">
                    Fill the form and we’ll reply soon
                </p>
            </div>

            <!-- Success message -->
            @if (session('success'))
            <div role="status"
                class="mb-5 flex items-start gap-3 rounded-xl border border-fn-green/25 bg-fn-green/10 px-4 py-3 text-sm text-fn-green">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="m20 6-11 11-5-5" />
                </svg>

                <p class="min-w-0 break-words">
                    {{ session('success') }}
                </p>
            </div>
            @endif

            <!-- Validation errors -->
            @if ($errors->any())
            <div role="alert"
                class="mb-5 px-4 py-3 bg-fn-red/10 border border-fn-red/25 rounded-xl text-sm text-fn-red">
                <p class="font-semibold mb-2">
                    Please correct the following errors:
                </p>

                <ul class="list-disc pl-5 space-y-1">
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
                    <label for="name" class="block mb-1.5 text-sm font-semibold text-fn-text2">
                        Full Name
                    </label>

                    <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                        maxlength="255" required aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                        @error('name') aria-describedby="name-error" @enderror
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border {{ $errors->has('name') ? 'border-fn-red/50' : 'border-fn-text/10' }} rounded-xl text-sm"
                        placeholder="John Doe">

                    @error('name')
                    <p id="name-error" class="mt-1.5 text-xs text-fn-red">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-1.5 text-sm font-semibold text-fn-text2">
                        Email
                    </label>

                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                        maxlength="255" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        @error('email') aria-describedby="email-error" @enderror
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border {{ $errors->has('email') ? 'border-fn-red/50' : 'border-fn-text/10' }} rounded-xl text-sm"
                        placeholder="john@email.com">

                    @error('email')
                    <p id="email-error" class="mt-1.5 text-xs text-fn-red">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block mb-1.5 text-sm font-semibold text-fn-text2">
                        Subject
                        <span class="font-normal text-fn-text3">(optional)</span>
                    </label>

                    <input id="subject" type="text" name="subject" value="{{ old('subject') }}" maxlength="255"
                        aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}" @error('subject')
                        aria-describedby="subject-error" @enderror
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border {{ $errors->has('subject') ? 'border-fn-red/50' : 'border-fn-text/10' }} rounded-xl text-sm"
                        placeholder="How can we help?">

                    @error('subject')
                    <p id="subject-error" class="mt-1.5 text-xs text-fn-red">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block mb-1.5 text-sm font-semibold text-fn-text2">
                        Message
                    </label>

                    <textarea id="message" name="message" rows="5" minlength="10" required
                        aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}" @error('message')
                        aria-describedby="message-error" @enderror
                        class="input-field w-full px-4 py-2.5 bg-fn-surface border {{ $errors->has('message') ? 'border-fn-red/50' : 'border-fn-text/10' }} rounded-xl text-sm resize-y"
                        placeholder="Write your message...">{{ old('message') }}</textarea>

                    @error('message')
                    <p id="message-error" class="mt-1.5 text-xs text-fn-red">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full py-3 bg-fn-blue hover:bg-fn-blue-l text-white font-semibold text-sm rounded-xl transition">
                    Send Message
                </button>
            </form>

            <!-- Extra -->
            <p class="text-center text-sm text-fn-text3 mt-6">
                We usually respond within 24 hours.
            </p>
        </div>
    </div>
</div>
@endsection
