<?php

use App\Models\Category;
use App\Models\Tool;
use App\Support\ToolMessages;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

it('has explicit translations for every audited detail message', function (string $locale) {
    $keys = json_decode(file_get_contents(base_path('tests/Fixtures/tool-detail-translation-keys.json')), true, flags: JSON_THROW_ON_ERROR);
    $catalog = json_decode(file_get_contents(lang_path($locale.'.json')), true, flags: JSON_THROW_ON_ERROR);

    foreach ($keys as $key) {
        expect(array_key_exists($key, $catalog))->toBeTrue("Missing {$locale} translation: {$key}");
        $value = $catalog[$key];
        expect($value)->toBeString();
        expect(trim($value))->not->toBe('');

        preg_match_all('/:value\d+/', $key, $sourceParameters);
        preg_match_all('/:value\d+/', $value, $translatedParameters);
        sort($sourceParameters[0]);
        sort($translatedParameters[0]);
        expect($translatedParameters[0])->toBe($sourceParameters[0], "Changed parameters in {$locale}: {$key}");
    }
})->with(['en', 'ar', 'fr', 'es', 'hi', 'zh_CN']);

function toolInputContract(string $html): array
{
    $document = new DOMDocument;
    $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NONET);
    $xpath = new DOMXPath($document);
    $contract = [];

    foreach ($xpath->query('//main//input | //main//select | //main//option | //main//button | //main//textarea') as $element) {
        if ($element->getAttribute('name') === '_token') {
            continue;
        }

        $fields = ['type', 'id', 'name', 'accept', 'data-mode', 'data-type', 'data-format', 'data-value', 'data-preset', 'data-action'];
        if ($element->tagName === 'option' || in_array($element->getAttribute('type'), ['checkbox', 'radio'], true)) {
            $fields[] = 'value';
        }

        $attributes = [];
        foreach ($fields as $field) {
            if ($element->hasAttribute($field)) {
                $attributes[$field] = $element->getAttribute($field);
            }
        }
        $contract[] = [$element->tagName, $attributes];
    }

    return $contract;
}

it('renders every tool detail language without changing form contracts', function (string $locale) {
    $category = Category::create(['title' => 'PDF Tools', 'slug' => 'pdf-tools']);

    foreach (glob(resource_path('views/tools/*.blade.php')) as $file) {
        $slug = basename($file, '.blade.php');
        if ($slug === 'index') {
            continue;
        }

        Tool::withoutEvents(fn () => Tool::create([
            'name' => 'Filenewer', 'slug' => $slug, 'title' => 'Filenewer',
            'description' => 'Filenewer', 'category_id' => $category->id, 'is_active' => true,
        ]));

        $english = $this->withSession(['locale' => 'en'])->get('/tools/'.$slug)->assertSuccessful();
        $translated = $this->withSession(['locale' => $locale])->get('/tools/'.$slug)->assertSuccessful();

        expect(toolInputContract($translated->getContent()))
            ->toBe(toolInputContract($english->getContent()), "Changed control IDs or API values on {$slug} in {$locale}");
    }
})->with(['ar', 'fr', 'es', 'hi', 'zh_CN']);

it('translates generated control labels while preserving markup and code', function () {
    app()->setLocale('fr');
    $html = '<button id="remove-1" data-mode="remove" title="Remove file"><svg viewBox="0 0 24 24"><path d="M1 2" /></svg><span>Remove file</span><span>:value0</span></button><code>Remove file</code>';
    $translated = ToolMessages::html($html);

    expect($translated)->toContain('id="remove-1" data-mode="remove"')
        ->toContain('viewBox="0 0 24 24"')
        ->toContain('title="'.e(__('Remove file')).'"')
        ->toContain('<span>'.e(__('Remove file')).'</span>')
        ->toContain('<span>:value0</span>')
        ->toContain('<code>Remove file</code>');
});

it('escapes translated text inside generated controls', function () {
    app()->setLocale('fr');
    app('translator')->addLines(['testing.unsafe' => '<script>alert("example")</script>'], 'fr');
    $translated = ToolMessages::html('<span class="label">testing.unsafe</span>');

    expect($translated)->not->toContain('<script>')
        ->toContain('&lt;script&gt;')
        ->toContain('class="label"');
});
