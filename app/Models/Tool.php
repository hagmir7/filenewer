<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'order',
        'category_id',
        'title',
        'body',
        'tags'
    ];


    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }



    public function category(){
        return $this->belongsTo(Category::class);
    }
}
