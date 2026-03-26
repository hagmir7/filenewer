<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'icon', 'description', 'slug'];


    public function tools(){
        return $this->hasMany(Tool::class);
    }
}
