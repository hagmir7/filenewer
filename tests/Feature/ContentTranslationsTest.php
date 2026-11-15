<?php

use App\Filament\Resources\Blogs\Pages\EditBlog;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Tools\Pages\EditTool;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Page;
use App\Models\Tool;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

function contentTranslationRecords(): array
{
    $category = Category::create(['title' => 'Source category', 'description' => 'Source category description', 'slug' => 'stable-category']);

    return [
        'category' => $category,
        'tool' => Tool::create([
            'name' => 'Source tool', 'title' => 'Source tool title', 'category_id' => $category->id,
            'description' => 'Source tool description', 'body' => '<p>Source tool body</p>',
            'tags' => ['popular', 'new'], 'is_active' => true,
        ]),
        'blog' => Blog::create([
            'title' => 'Source blog', 'excerpt' => 'Source blog excerpt', 'content' => '<p>Source blog content</p>',
            'category' => 'Source blog category', 'user_id' => User::factory()->create()->id,
            'is_published' => true, 'published_at' => '2026-11-15 12:00:00',
        ]),
        'page' => Page::create([
            'title' => 'Source page', 'description' => 'Source page description',
            'content' => '<p>Source page content</p>', 'is_published' => true,
        ]),
    ];
}

function contentTranslationValue(string $model, string $attribute, string $type, string $locale): string|array
{
    $value = 'Saved '.$model.' '.$attribute.' '.$locale;

    return match ($type) {
        'rich' => '<h2>'.$value.'</h2><p><strong>Rich formatting.</strong></p>',
        'tags' => [$value, 'Second keyword '.$locale],
        default => $value,
    };
}

it('renders translated database content and metadata while preserving URLs and filters', function (string $locale) {
    $records = contentTranslationRecords();

    foreach ($records as $name => $record) {
        foreach ($record::TRANSLATABLE_CONTENT as $attribute => $type) {
            $record->setAttribute($attribute.'_translations', collect(config('app.supported_locales'))
                ->mapWithKeys(fn (array $language, string $code): array => [$code => contentTranslationValue($name, $attribute, $type, $code)])->all());
        }
        $record->save();
    }

    $this->withSession(['locale' => $locale]);
    $tool = $records['tool'];
    $blog = $records['blog'];
    $page = $records['page'];

    $this->get('/tools?category=stable-category')->assertSuccessful()
        ->assertSee('Saved category title '.$locale)
        ->assertSee('Saved category description '.$locale)
        ->assertSee('Saved tool name '.$locale)
        ->assertSee('Saved tool description '.$locale)
        ->assertSee('saved tool tags '.strtolower($locale))
        ->assertSee('data-tags="popular,new"', false)
        ->assertSee('/tools/'.$tool->slug, false);

    $this->get('/tools/'.$tool->slug)->assertSuccessful()
        ->assertSee('Saved tool name '.$locale)
        ->assertSee('<title>Saved tool title '.$locale.' | Filenewer</title>', false)
        ->assertSee('content="Saved tool tags '.$locale.', Second keyword '.$locale.'"', false)
        ->assertSee(contentTranslationValue('tool', 'body', 'rich', $locale), false)
        ->assertSee(__('Popular', [], $locale))
        ->assertSee(__('New', [], $locale))
        ->assertSee('/tools?category=stable-category', false);

    $this->get('/blog')->assertSuccessful()
        ->assertSee('Saved blog title '.$locale)
        ->assertSee('Saved blog excerpt '.$locale)
        ->assertSee('Saved blog category '.$locale)
        ->assertSee('/blog/'.$blog->slug, false);
    $this->get('/blog/'.$blog->slug)->assertSuccessful()
        ->assertSee('<title>Saved blog title '.$locale.' | Filenewer</title>', false)
        ->assertSee('content="Saved blog excerpt '.$locale.'"', false)
        ->assertSee(contentTranslationValue('blog', 'content', 'rich', $locale), false)
        ->assertSee('/blog?cat=source-blog-category', false)
        ->assertDontSee('Source blog content');

    $this->get('/pages')->assertSuccessful()
        ->assertSee('Saved page title '.$locale)
        ->assertSee('Saved page description '.$locale)
        ->assertSee('/pages/'.$page->slug, false);
    $this->get('/pages/'.$page->slug)->assertSuccessful()
        ->assertSee('<title>Saved page title '.$locale.' | Filenewer</title>', false)
        ->assertSee('content="Saved page description '.$locale.'"', false)
        ->assertSee(contentTranslationValue('page', 'content', 'rich', $locale), false)
        ->assertDontSee('Source page content');

    expect($tool->fresh()->name)->toBe('Source tool')
        ->and($tool->fresh()->tags)->toBe(['popular', 'new'])
        ->and($blog->fresh()->title)->toBe('Source blog')
        ->and($page->fresh()->title)->toBe('Source page');
})->with(['en', 'ar', 'fr', 'es', 'hi', 'zh_CN']);

it('saves all translated fields in admin without changing defaults or other languages', function (string $name, string $editPage) {
    $records = contentTranslationRecords();
    $record = $records[$name];
    $originals = $record->getRawOriginal();
    $updates = [];
    $expected = [];

    foreach ($record::TRANSLATABLE_CONTENT as $attribute => $type) {
        $arabic = contentTranslationValue($name, $attribute, $type, 'ar');
        $record->setAttribute($attribute.'_translations', ['ar' => $arabic]);
        $expected[$attribute] = contentTranslationValue($name, $attribute, $type, 'fr');
        $updates[$attribute.'_translations.fr'] = $expected[$attribute];
    }
    $record->save();

    Filament::setCurrentPanel(Filament::getPanel('admin'));
    $this->actingAs(User::factory()->create());
    app()->setLocale('ar');

    if ($record instanceof Category) {
        Livewire::test($editPage)
            ->callAction(TestAction::make('edit')->table($record), data: $updates)
            ->assertHasNoActionErrors();
    } else {
        Livewire::test($editPage, ['record' => $record->getRouteKey()])
            ->fillForm($updates)
            ->call('save')
            ->assertHasNoFormErrors();
    }

    $record->refresh();
    foreach ($record::TRANSLATABLE_CONTENT as $attribute => $type) {
        expect($record->localized($attribute, 'fr'))->toBe($expected[$attribute])
            ->and($record->getAttribute($attribute.'_translations')['ar'])->toBe(contentTranslationValue($name, $attribute, $type, 'ar'));

        if ($attribute !== 'tags') {
            expect($record->getRawOriginal($attribute))->toBe($originals[$attribute]);
        }
    }
    expect($record->slug)->toBe($originals['slug']);

    if ($record instanceof Tool) {
        expect($record->sourceTags())->toBe(['popular', 'new']);
    }
})->with([
    ['tool', EditTool::class], ['category', ListCategories::class], ['blog', EditBlog::class], ['page', EditPage::class],
]);

it('uses defaults for blank translations and only exposes translatable columns', function () {
    foreach (contentTranslationRecords() as $name => $record) {
        foreach ($record::TRANSLATABLE_CONTENT as $attribute => $type) {
            $original = $record->getAttribute($attribute);
            $record->setAttribute($attribute.'_translations', ['fr' => match ($type) {
                'rich' => '<p>&nbsp;<br></p>', 'tags' => [' ', ''], default => '  ',
            }]);
            expect($record->localized($attribute, 'fr'))->toBe($original);
            $fallback = contentTranslationValue($name, $attribute, $type, 'en');
            $record->setAttribute($attribute.'_translations', ['en' => $fallback]);
            expect($record->localized($attribute, 'fr'))->toBe($fallback);
        }

        expect(fn () => $record->localized('slug'))->toThrow(InvalidArgumentException::class);
    }

    foreach ([Tool::class => ['name', 'title', 'description', 'body', 'tags'], Category::class => ['title', 'description'], Blog::class => ['title', 'excerpt', 'content', 'category'], Page::class => ['title', 'description', 'content']] as $class => $attributes) {
        $columns = array_values(array_filter(Schema::getColumnListing((new $class)->getTable()), fn (string $column): bool => str_ends_with($column, '_translations')));
        expect($columns)->toEqualCanonicalizing(array_map(fn (string $attribute): string => $attribute.'_translations', $attributes));
    }

    $legacy = new Tool;
    $legacy->setRawAttributes(['tags' => 'popular,new']);
    expect($legacy->sourceTags())->toBe(['popular', 'new'])
        ->and($legacy->localized('tags', 'en'))->toBe(['popular', 'new']);
});
