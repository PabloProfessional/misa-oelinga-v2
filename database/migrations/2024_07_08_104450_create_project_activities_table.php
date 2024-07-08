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
        Schema::create('project_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('project_id');
            $table->integer('activity_type_id');
            $table->integer('user_id');
            $table->integer('manager_id');
            $table->integer('stakeholder_id');
            $table->integer('location');
            $table->integer('stage_type_id');
            $table->integer('status_type_id');
            $table->decimal('budget', 10, 2)->nullable();
            $table->decimal('spend', 10, 2)->nullable();
            $table->longText('description')->nullable();
            $table->string('url')->unique();
            $table->string('color')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('team_members')->nullable();
            $table->json('attachments')->nullable();
            $table->text('notes')->nullable();
            $table->integer('priority_id')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_activities');
    }
};
