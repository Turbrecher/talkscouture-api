<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "title" => "string",
        "subtitle" => "string",
        "content" => "string",
        "writer" => "int",
        "photo" => "string",
        "date" => "string",
        "time" => "string",
        "section" => "string"
    ];

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
