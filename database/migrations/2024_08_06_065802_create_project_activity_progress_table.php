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
        Schema::create('project_activity_progress', function (Blueprint $table) {
            $table->id();
            $table->integer('project_activity_id');
            $table->integer('spend');
            $table->integer('percentage_completion');
            $table->string('file');
            $table->boolean('is_approved')->default(false);
            $table->integer('user_id');
            $table->string('custom_1')->nullable();
            $table->integer('custom_2')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_activity_progress');
    }
};
