<?php

use App\Models\User;
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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("short_title");
            $table->string("description");
            $table->string("content");
            $table->string("section");
            $table->string("readTime");
            $table->string("date");
            $table->string("time");
            $table->string("headerPhoto");
            $table->string("thumbnail");
            $table->integer("writer_id")->unsigned();
            $table->foreign("writer_id")->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
