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
            $table->mediumText("title");
            $table->mediumText("short_title");
            $table->mediumText("description");
            $table->mediumText("content");
            $table->string("section");
            $table->string("readTime");
            $table->string("date");
            $table->string("time");
            $table->string("headerPhoto");
            $table->string("thumbnail");
            $table->unsignedBigInteger("writer_id");
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
