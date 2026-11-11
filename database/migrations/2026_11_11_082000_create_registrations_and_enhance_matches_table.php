<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('registrations')) {
            Schema::create('registrations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
                $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('status')->default('pending');
                $table->text('admin_note')->nullable();
                $table->dateTime('registration_date')->nullable();
                $table->dateTime('verified_at')->nullable();
                $table->timestamps();

                $table->unique(['tournament_id', 'team_id'], 'tournament_team_unique');
                $table->index(['tournament_id', 'status']);
                $table->index(['user_id']);
            });
        }

        Schema::table('match_schedules', function (Blueprint $table) {
            if (! Schema::hasColumn('match_schedules', 'winner_id')) {
                $table->foreignId('winner_id')
                    ->nullable()
                    ->after('team_b_id')
                    ->constrained('teams')
                    ->nullOnDelete();
            }
            if (! Schema::hasColumn('match_schedules', 'team_a_score')) {
                $table->integer('team_a_score')->nullable()->after('winner_id');
            }
            if (! Schema::hasColumn('match_schedules', 'team_b_score')) {
                $table->integer('team_b_score')->nullable()->after('team_a_score');
            }
        });

        // Buat SQL View 'matches' agar referensi tabel matches tersedia di MySQL dan SQLite
        DB::statement('DROP VIEW IF EXISTS matches');
        DB::statement('CREATE VIEW matches AS SELECT * FROM match_schedules');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS matches');

        Schema::table('match_schedules', function (Blueprint $table) {
            $table->dropForeign(['winner_id']);
            $table->dropColumn(['winner_id', 'team_a_score', 'team_b_score']);
        });

        Schema::dropIfExists('registrations');
    }
};
