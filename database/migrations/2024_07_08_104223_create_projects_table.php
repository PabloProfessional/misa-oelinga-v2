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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->integer('user_id');
            $table->string('url')->unique();
            $table->integer('procurement_status_id');
            $table->string('project_number')->unique();
            $table->integer('programme_id');
            $table->integer('department_id');
            $table->integer('sector_id');
            $table->string('province_url');
            $table->integer('municipal_id');
            $table->integer('manager')->nullable();
            $table->longText('description')->nullable();
            $table->string('logo')->unique()->nullable();
            $table->json('data')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('stage_type_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('budget')->nullable();
            $table->integer('spend' )->nullable();
            $table->integer('priority_id')->nullable();
            $table->json('tags')->nullable();
            $table->integer('client_id')->nullable();
            $table->json('team_members')->nullable();
            $table->json('attachments')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
