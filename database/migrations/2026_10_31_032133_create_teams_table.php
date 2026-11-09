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
    Schema::create('teams', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
        $table->string('team_name');
        $table->string('school_name');
        $table->string('leader_name');
        $table->string('leader_email');
        $table->string('leader_phone');
        $table->string('status')->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
