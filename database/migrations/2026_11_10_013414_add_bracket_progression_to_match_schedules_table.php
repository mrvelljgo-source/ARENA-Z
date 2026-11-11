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
        Schema::table('match_schedules', function (Blueprint $table) {
            $table->foreignId('team_a_id')->nullable()->change();
            $table->foreignId('team_b_id')->nullable()->change();
            $table->foreignId('team_a_source_match_id')
                ->nullable()
                ->constrained('match_schedules')
                ->nullOnDelete();
            $table->string('team_a_source_outcome')->nullable();
            $table->foreignId('team_b_source_match_id')
                ->nullable()
                ->constrained('match_schedules')
                ->nullOnDelete();
            $table->string('team_b_source_outcome')->nullable();
            $table->boolean('is_bracket_generated')->default(false);
            $table->boolean('is_conditional')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $hasUnassignedTeams = DB::table('match_schedules')
            ->whereNull('team_a_id')
            ->orWhereNull('team_b_id')
            ->exists();

        if ($hasUnassignedTeams) {
            throw new RuntimeException(
                'Resolve or remove bracket matches with unassigned teams before rolling back this migration.'
            );
        }

        Schema::table('match_schedules', function (Blueprint $table) {
            $table->dropForeign(['team_a_source_match_id']);
            $table->dropForeign(['team_b_source_match_id']);
            $table->dropColumn([
                'team_a_source_match_id',
                'team_a_source_outcome',
                'team_b_source_match_id',
                'team_b_source_outcome',
                'is_bracket_generated',
                'is_conditional',
            ]);
            $table->foreignId('team_a_id')->nullable(false)->change();
            $table->foreignId('team_b_id')->nullable(false)->change();
        });
    }
};
