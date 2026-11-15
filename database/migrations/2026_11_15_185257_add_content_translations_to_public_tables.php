<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->columns() as $name => $columns) {
            Schema::table($name, function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    $table->json($column.'_translations')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->columns() as $name => $columns) {
            Schema::table($name, function (Blueprint $table) use ($columns) {
                $table->dropColumn(array_map(fn (string $column): string => $column.'_translations', $columns));
            });
        }
    }

    private function columns(): array
    {
        return [
            'tools' => ['name', 'title', 'tags'],
            'categories' => ['title', 'description'],
            'blogs' => ['title', 'excerpt', 'content', 'category'],
            'pages' => ['title', 'description', 'content'],
        ];
    }
};
