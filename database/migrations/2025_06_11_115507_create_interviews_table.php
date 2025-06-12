<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
         Schema::create('interviews', function (Blueprint $table) {
        $table->id();
        $table->string('role');
        $table->string('type');
        $table->string('level');
        $table->json('techstack');
        $table->json('questions');
        $table->string('user_id');
        $table->boolean('finalized')->default(false);
        $table->string('cover_image')->nullable();
        $table->timestamps(); // created_at and updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
