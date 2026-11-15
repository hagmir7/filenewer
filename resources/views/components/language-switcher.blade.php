<form method="POST" action="{{ route('locale.update') }}" class="flex items-center gap-2">
    @csrf
    <input type="hidden" name="return_to" value="{{ request()->getRequestUri() }}">
    <label for="site-language" class="sr-only">{{ __('Language') }}</label>
    <select id="site-language" name="locale" aria-label="{{ __('Language') }}"
        class="max-w-28 sm:max-w-36 rounded-lg border border-white/10 bg-fn-surface px-2 py-2 text-sm text-fn-text focus:border-fn-blue focus:outline-none"
        onchange="this.form.requestSubmit()">
        @foreach (config('app.supported_locales') as $code => $language)
        <option value="{{ $code }}" lang="{{ $language['language'] }}" dir="{{ $language['direction'] }}" @selected(app()->getLocale() === $code)>{{ $language['name'] }}</option>
        @endforeach
    </select>
    <noscript>
        <button type="submit" class="rounded-lg bg-fn-blue px-3 py-2 text-sm text-white">{{ __('Apply') }}</button>
    </noscript>
</form>
