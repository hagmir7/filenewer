<?php

beforeEach(function () {
    $this->withoutVite();
});

it('renders the default English interface', function () {
    $this->get('/login')
        ->assertSuccessful()
        ->assertSee('lang="en" dir="ltr"', false)
        ->assertSee('Welcome back');
});

it('remembers each supported language and renders its interface', function (string $locale, string $language, string $direction, string $heading) {
    $this->post(route('locale.update'), ['locale' => $locale, 'return_to' => '/login?source=tools'])
        ->assertRedirect('/login?source=tools')
        ->assertSessionHas('locale', $locale);

    $this->get('/login')
        ->assertSuccessful()
        ->assertSee('lang="'.$language.'" dir="'.$direction.'"', false)
        ->assertSee($heading);

    $this->get('/signup')->assertSuccessful()->assertSee(__('Create your account', [], $locale));
})->with([
    ['en', 'en', 'ltr', 'Welcome back'],
    ['ar', 'ar', 'rtl', 'مرحبًا بعودتك'],
    ['fr', 'fr', 'ltr', 'Heureux de vous revoir'],
    ['es', 'es', 'ltr', 'Te damos la bienvenida de nuevo'],
    ['hi', 'hi', 'ltr', 'वापसी पर स्वागत है'],
    ['zh_CN', 'zh-CN', 'ltr', '欢迎回来'],
]);

it('rejects unsupported language selections without replacing the saved language', function (mixed $locale) {
    $this->withSession(['locale' => 'fr'])
        ->postJson(route('locale.update'), ['locale' => $locale, 'return_to' => '/login'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('locale')
        ->assertSessionHas('locale', 'fr');
})->with(['de', '../ar', '', 'array' => [['ar']]]);

it('rejects unsafe return destinations', function (mixed $destination) {
    $this->postJson(route('locale.update'), ['locale' => 'ar', 'return_to' => $destination])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('return_to')
        ->assertSessionMissing('locale');
})->with(['https://example.org', '//example.org', '/\\example.org', "/\n/example.org", 'array' => [['login']]]);

it('falls back to English when a session contains an unsupported language', function () {
    $this->withSession(['locale' => '../../bad'])
        ->get('/login')
        ->assertSuccessful()
        ->assertSee('lang="en" dir="ltr"', false)
        ->assertSee('Welcome back');
});

it('does not carry a previous requests locale into a session without a language preference', function () {
    $this->withSession(['locale' => 'ar'])->get('/login')->assertSee('lang="ar"', false);
    session()->forget('locale');
    $this->get('/login')->assertSee('lang="en"', false);
});

it('uses Laravel Lang validation messages in the selected language', function (string $locale) {
    $response = $this->withSession(['locale' => $locale])->postJson('/signup', []);

    $response->assertUnprocessable()->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password', 'terms']);
    expect($response->json('errors.email.0'))->toBe(
        __('validation.required', ['attribute' => __('validation.attributes.email', [], $locale)], $locale)
    );
    expect(__('validation.required', [], $locale))->not->toBe(__('validation.required', [], 'en'));
})->with(['ar', 'fr', 'es', 'hi', 'zh_CN']);

it('falls back to English for missing application translations', function () {
    app('translator')->addLines(['localization_test.only_english' => 'English fallback'], 'en');
    app()->setLocale('ar');

    expect(__('localization_test.only_english'))->toBe('English fallback');
});

it('translates the login password placeholder', function (string $locale, string $placeholder) {
    $this->withSession(['locale' => $locale])
        ->get('/login')
        ->assertSuccessful()
        ->assertSee('placeholder="'.e($placeholder).'"', false);

    expect(__('Enter your password', [], $locale))->toBe($placeholder);
})->with([
    ['en', 'Enter your password'],
    ['ar', 'أدخل كلمة المرور'],
    ['fr', 'Saisissez votre mot de passe'],
    ['es', 'Introduce tu contraseña'],
    ['hi', 'अपना पासवर्ड दर्ज करें'],
    ['zh_CN', '请输入密码'],
]);
