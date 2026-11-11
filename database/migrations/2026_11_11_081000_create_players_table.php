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
        if (! Schema::hasTable('players')) {
            Schema::create('players', function (Blueprint $table) {
                $table->id();
                $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
                $table->string('name');
                $table->string('in_game_name');
                $table->string('game_id');
                $table->string('role_in_game');
                $table->string('student_grade');
                $table->string('phone_number')->nullable();
                $table->boolean('is_captain')->default(false);
                $table->boolean('is_substitute')->default(false);
                $table->timestamps();

                $table->index('team_id');
                $table->index('is_captain');
                $table->index('is_substitute');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
