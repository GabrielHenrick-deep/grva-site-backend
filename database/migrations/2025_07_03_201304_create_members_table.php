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
        Schema::create('members', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('foto')->nullable();
            $table->string('cell')->nullable();
            $table->string('email')->nullable();
            $table->string('category')->nullable();
            $table->string('pesquisa')->nullable();
            $table->string('lattes')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('orcid')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
