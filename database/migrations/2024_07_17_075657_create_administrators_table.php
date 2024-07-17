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
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('email')->unique();
            $table->boolean('active')->default(false);
            $table->string('custom_1')->nullable();
            $table->integer('custom_2')->nullable();
            $table->boolean('custom_3')->nullable();
            $table->float('custom_4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrators');
    }
};
