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
        Schema::create('project_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('project_id');
            $table->integer('activity_id')->nullable();
            $table->integer('debit')->nullable();
            $table->integer('credit')->nullable();
            $table->integer('balance');
            $table->longText('description');
            $table->string('custom_1')->nullable();
            $table->integer('custom_2')->nullable();
            $table->boolean('custom_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_accounts');
    }
};
