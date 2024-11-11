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
        Schema::create('destinasi_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destinasi_id');
            $table->foreignId('provider_id');
            $table->string('signal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasi_providers');
    }
};
