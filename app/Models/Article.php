<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "title" => "string",
        "description" => "string",
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
}
