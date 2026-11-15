<?php

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

it('localizes reading times and publication dates on blog pages', function (string $locale, string $oneMinute, string $twoMinutes, string $fiveMinutes, string $fullDate, string $shortMonth) {
    $author = User::factory()->create();
    $featured = Blog::create([
        'title' => 'Featured localization article',
        'content' => 'A short article.',
        'user_id' => $author->id,
        'is_published' => true,
        'published_at' => '2026-11-15 12:00:00',
    ]);
    Blog::create([
        'title' => 'Second localization article',
        'content' => str_repeat('word ', 201),
        'user_id' => $author->id,
        'is_published' => true,
        'published_at' => '2026-11-14 12:00:00',
    ]);

    $this->withSession(['locale' => $locale]);
    $index = $this->get('/blog')->assertSuccessful()
        ->assertSee($oneMinute)
        ->assertSee($twoMinutes)
        ->assertSee($shortMonth);
    $article = $this->get('/blog/'.$featured->slug)->assertSuccessful()
        ->assertSee($fiveMinutes)
        ->assertSee($fullDate)
        ->assertSee($shortMonth);

    if ($locale !== 'en') {
        $index->assertDontSee('min read');
        $article->assertDontSee('min read')->assertDontSee('November');
    }

    $this->withSession(['locale' => 'en'])->get('/blog/'.$featured->slug)
        ->assertSuccessful()->assertSee('5 min read')->assertSee('November 15, 2026');
})->with([
    ['en', '1 min read', '2 min read', '5 min read', 'November 15, 2026', 'Nov'],
    ['ar', 'دقيقة واحدة للقراءة', 'دقيقتان للقراءة', '5 دقائق للقراءة', '15 نوفمبر 2026', 'نوفمبر'],
    ['fr', '1 minute de lecture', '2 minutes de lecture', '5 minutes de lecture', '15 novembre 2026', 'nov.'],
    ['es', '1 minuto de lectura', '2 minutos de lectura', '5 minutos de lectura', '15 de noviembre de 2026', 'nov'],
    ['hi', 'पढ़ने का समय: 1 मिनट', 'पढ़ने का समय: 2 मिनट', 'पढ़ने का समय: 5 मिनट', '15 नवम्बर 2026', 'नव.'],
    ['zh_CN', '1 分钟阅读', '2 分钟阅读', '5 分钟阅读', '2026年11月15日', '11月'],
]);

it('renders public database backed pages in every supported language', function (string $locale) {
    $category = Category::create(['title' => 'PDF Tools', 'slug' => 'pdf']);
    Tool::create([
        'name' => 'PDF to Word',
        'title' => 'PDF to Word',
        'category_id' => $category->id,
        'description' => 'Original authored tool description',
        'is_active' => true,
    ]);

    $this->withSession(['locale' => $locale]);
    $this->get('/')
        ->assertSuccessful()
        ->assertSee(__('Browse tools by category', [], $locale))
        ->assertSee(__('PDF Tools', [], $locale));

    $this->get('/tools?category=pdf&q=PDF')
        ->assertSuccessful()
        ->assertSee(__('PDF Tools', [], $locale))
        ->assertSee('Original authored tool description')
        ->assertSee('value="/tools?category=pdf&amp;q=PDF"', false);

    $this->get('/blog')->assertSuccessful()->assertSee(__('The Filenewer Blog', [], $locale));
    $this->get('/pages')->assertSuccessful()->assertSee(__('Pages', [], $locale));
    $this->get('/contact')->assertSuccessful()->assertSee(__('Contact Us', [], $locale));
    $this->get('/forgot-password')->assertSuccessful()->assertSee(__('Forgot your password?', [], $locale));
})->with(['en', 'ar', 'fr', 'es', 'hi', 'zh_CN']);

it('publishes matching JSON translation catalogs and framework messages', function (string $locale) {
    $english = json_decode(file_get_contents(lang_path('en.json')), true, flags: JSON_THROW_ON_ERROR);
    $translations = json_decode(file_get_contents(lang_path($locale.'.json')), true, flags: JSON_THROW_ON_ERROR);

    expect(array_keys($translations))->toEqual(array_keys($english));

    foreach (['auth', 'passwords', 'pagination', 'validation'] as $group) {
        expect(is_file(lang_path($locale.'/'.$group.'.php')))->toBeTrue();
    }
})->with(['en', 'ar', 'fr', 'es', 'hi', 'zh_CN']);

it('uses localized singular and plural tool counts', function () {
    app()->setLocale('en');
    expect(trans_choice('tool_count', 1, ['count' => 1]))->toBe('1 tool')
        ->and(trans_choice('tool_count', 2, ['count' => 2]))->toBe('2 tools');

    app()->setLocale('ar');
    expect(trans_choice('tool_count', 2, ['count' => 2]))->toBe('أداتان');
});

it('translates tool cards FAQs metadata and JavaScript feedback', function (string $locale) {
    $category = Category::create([
        'title' => 'PDF Tools',
        'slug' => 'pdf-tools',
        'description' => 'Convert, edit, compress and manage PDF files.',
    ]);
    $tool = Tool::create([
        'name' => 'PDF to Word',
        'title' => 'PDF to Word Converter – Free Online PDF to DOCX',
        'description' => 'Convert PDF to DOCX.',
        'category_id' => $category->id,
        'is_active' => true,
    ]);

    $this->withSession(['locale' => $locale]);
    $home = $this->get('/')->assertSuccessful();
    $home->assertSee('<title>'.e(__('Filenewer – Free Online File Converter, PDF & Image Tools', [], $locale)).'</title>', false)
        ->assertSee(__('Is Filenewer free to use?', [], $locale))
        ->assertSee(__('Yes. All Filenewer tools are free to use, and you do not need to create an account to convert, compress, merge or split your files.', [], $locale))
        ->assertSee(__('Convert PDF to DOCX.', [], $locale));

    $directory = $this->get('/tools?category=pdf-tools')->assertSuccessful();
    $directory->assertSee(__('Convert, edit, compress and manage PDF files.', [], $locale))
        ->assertSee('data-name="'.e(Str::lower(__('PDF to Word', [], $locale).' PDF to Word')).'"', false)
        ->assertSee('/tools/pdf-to-word', false);

    $converter = $this->get('/tools/'.$tool->slug)->assertSuccessful();
    $converter->assertSee(__($tool->title, [], $locale))
        ->assertSee(__('Drop your PDF here', [], $locale))
        ->assertSee(__('Convert to Word', [], $locale))
        ->assertSee(__('Output Format', [], $locale))
        ->assertSee((string) Illuminate\Support\Js::from(__('Uploading file…', [], $locale)), false)
        ->assertSee((string) Illuminate\Support\Js::from(__('Conversion failed. Please try again.', [], $locale)), false);

    expect(__('PDF to Word', [], $locale))->not->toBe('PDF to Word')
        ->and(__('Is Filenewer free to use?', [], $locale))->not->toBe('Is Filenewer free to use?')
        ->and(__('Drop your PDF here', [], $locale))->not->toBe('Drop your PDF here');
})->with(['ar', 'fr', 'es', 'hi', 'zh_CN']);

it('compiles every public Blade template after adding translation expressions', function () {
    foreach (Illuminate\Support\Facades\File::allFiles(resource_path('views')) as $file) {
        if (! str_ends_with($file->getFilename(), '.blade.php')) {
            continue;
        }

        try {
            $compiled = app('blade.compiler')->compileString($file->getContents());
            token_get_all($compiled, TOKEN_PARSE);
        } catch (Throwable $exception) {
            $this->fail($file->getRelativePathname().': '.$exception->getMessage());
        }
    }

    $this->assertTrue(true);
});
