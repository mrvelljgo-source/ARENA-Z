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
        Schema::table('tournaments', function (Blueprint $table) {
            if (! Schema::hasColumn('tournaments', 'description')) {
                $table->text('description')->nullable()->after('game');
            }
            if (! Schema::hasColumn('tournaments', 'rules')) {
                $table->text('rules')->nullable()->after('description');
            }
            if (! Schema::hasColumn('tournaments', 'prize_pool')) {
                $table->string('prize_pool')->nullable()->after('rules');
            }
            if (! Schema::hasColumn('tournaments', 'max_teams')) {
                $table->integer('max_teams')->default(16)->after('prize_pool');
            }
            if (! Schema::hasColumn('tournaments', 'banner_image')) {
                $table->string('banner_image')->nullable()->after('max_teams');
            }
            if (! Schema::hasColumn('tournaments', 'format')) {
                $table->string('format')->default('5 VS 5 Single Elimination')->after('banner_image');
            }
        });

        Schema::table('teams', function (Blueprint $table) {
            if (! Schema::hasColumn('teams', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('status');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'school_name')) {
                $table->string('school_name')->nullable()->after('role');
            }
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('school_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn(['description', 'rules', 'prize_pool', 'max_teams', 'banner_image', 'format']);
        });

        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['admin_note']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['school_name', 'phone']);
        });
    }
};
