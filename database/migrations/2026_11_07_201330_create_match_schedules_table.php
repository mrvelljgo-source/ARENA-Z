
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tournament_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('team_a_id')
                ->constrained('teams')
                ->cascadeOnDelete();

            $table->foreignId('team_b_id')
                ->constrained('teams')
                ->cascadeOnDelete();

            $table->date('match_date')->nullable();
            $table->time('match_time')->nullable();

            $table->string('round')->default('Babak Penyisihan');

            $table->enum('status', ['upcoming', 'live', 'finished'])
                ->default('upcoming');

            $table->string('result')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_schedules');
    }
};
