<?php

use App\Filament\Resources\Tools\Pages\CreateTool;
use App\Filament\Resources\Tools\Pages\EditTool;
use App\Models\Category;
use App\Models\Tool;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

it('displays saved tool descriptions and rich content in the selected language', function (string $locale) {
    $category = Category::create(['title' => 'PDF Tools', 'slug' => 'pdf-tools']);
    $translations = collect(config('app.supported_locales'))
        ->mapWithKeys(fn (array $language, string $code): array => [$code => 'Saved description '.$code])->all();
    $bodies = collect(config('app.supported_locales'))
        ->mapWithKeys(fn (array $language, string $code): array => [$code => '<h2>Saved rich content '.$code.'</h2><p><strong>Formatting survives.</strong></p>'])->all();

    foreach (['custom-content-tool', 'pdf-to-word'] as $name) {
        $tool = Tool::create([
            'name' => $name, 'title' => 'Original title', 'category_id' => $category->id,
            'description' => 'Original description', 'body' => '<p>Original body.</p>',
            'description_translations' => $translations, 'body_translations' => $bodies,
            'is_active' => true,
        ]);

        $this->withSession(['locale' => $locale])->get('/tools/'.$tool->slug)
            ->assertSuccessful()
            ->assertSee('Saved description '.$locale)
            ->assertSee('<meta name="description" content="Saved description '.$locale.'"', false)
            ->assertSee($bodies[$locale], false)
            ->assertDontSee('Original description')
            ->assertDontSee('Original body.');

        expect($tool->fresh()->description)->toBe('Original description')
            ->and($tool->fresh()->body)->toBe('<p>Original body.</p>');
    }

    $this->get('/tools')->assertSuccessful()->assertSee('Saved description '.$locale);
})->with(['en', 'ar', 'fr', 'es', 'hi', 'zh_CN']);

it('falls back for missing or empty translations without translating rich markup', function () {
    $tool = new Tool([
        'description' => 'Convert PDF to DOCX.', 'body' => '<p>Original <strong>HTML</strong>.</p>',
        'description_translations' => ['fr' => '  ', 'ar' => null],
        'body_translations' => ['fr' => '<p><br></p>', 'ar' => '<p>&nbsp;</p>'],
    ]);

    foreach (['fr', 'ar', 'es', 'hi', 'zh_CN'] as $locale) {
        expect($tool->localizedDescription($locale))->toBe(__('Convert PDF to DOCX.', [], $locale))
            ->and($tool->localizedBody($locale))->toBe('<p>Original <strong>HTML</strong>.</p>');
    }

    $tool->body_translations = ['ar' => '<p><img src="/image.png" alt=""></p>'];
    expect($tool->localizedBody('ar'))->toBe('<p><img src="/image.png" alt=""></p>');

    $tool->description_translations = ['en' => 'Fallback description'];
    $tool->body_translations = ['en' => '<p>Fallback content.</p>'];
    expect($tool->localizedDescription('fr'))->toBe('Fallback description')
        ->and($tool->localizedBody('fr'))->toBe('<p>Fallback content.</p>');
});

it('creates a tool with translated content through the admin language tabs', function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
    $this->actingAs(User::factory()->create());
    $category = Category::create(['title' => 'PDF Tools', 'slug' => 'pdf-tools']);

    Livewire::test(CreateTool::class)
        ->fillForm([
            'name' => 'Translation creation', 'title' => 'Original title', 'slug' => 'translation-creation',
            'category' => $category->id, 'description' => 'Original description',
            'body' => '<p>Original content.</p>',
            'description_translations' => ['ar' => 'وصف عربي', 'fr' => 'Description française'],
            'body_translations' => ['ar' => '<p>محتوى عربي.</p>', 'fr' => '<p>Contenu français.</p>'],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $tool = Tool::where('slug', 'translation-creation')->firstOrFail();
    expect($tool->description)->toBe('Original description')
        ->and($tool->description_translations['ar'])->toBe('وصف عربي')
        ->and($tool->body_translations['fr'])->toBe('<p>Contenu français.</p>');
});

it('edits translations without replacing originals or other languages', function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
    $this->actingAs(User::factory()->create());
    $category = Category::create(['title' => 'PDF Tools', 'slug' => 'pdf-tools']);
    $tool = Tool::create([
        'name' => 'Translation editing', 'title' => 'Original title', 'category_id' => $category->id,
        'description' => 'Original description', 'body' => '<p>Original content.</p>',
        'description_translations' => ['ar' => 'وصف عربي', 'fr' => 'Ancienne description'],
        'body_translations' => ['ar' => '<p>محتوى عربي.</p>', 'fr' => '<p>Ancien contenu.</p>'],
    ]);
    app()->setLocale('ar');

    Livewire::test(EditTool::class, ['record' => $tool->getRouteKey()])
        ->assertFormSet(['description' => 'Original description', 'description_translations.ar' => 'وصف عربي'])
        ->fillForm([
            'description_translations.fr' => 'Nouvelle description',
            'body_translations.fr' => '<p>Nouveau contenu.</p>',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $tool->refresh();
    expect($tool->description)->toBe('Original description')
        ->and($tool->body)->toBe('<p>Original content.</p>')
        ->and($tool->description_translations['ar'])->toBe('وصف عربي')
        ->and($tool->body_translations['ar'])->toBe('<p>محتوى عربي.</p>')
        ->and($tool->localizedDescription('fr'))->toBe('Nouvelle description')
        ->and($tool->localizedBody('fr'))->toBe('<p>Nouveau contenu.</p>');
});
