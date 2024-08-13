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
        Schema::table('project_accounts', function (Blueprint $table) {
            //
            $table->bigInteger('debit')->change();
            $table->bigInteger('credit')->change();
            $table->bigInteger('balance')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_accounts', function (Blueprint $table) {
            //
        });
    }
};
