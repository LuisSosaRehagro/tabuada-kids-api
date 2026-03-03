<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('child_id')->constrained('child_profiles')->onDelete('cascade');
            $table->string('mode', 10)->comment('study ou play');
            $table->smallInteger('table_number');
            $table->smallInteger('correct_answers')->default(0);
            $table->smallInteger('total_questions')->default(10);
            $table->timestamp('completed_at')->default(DB::raw('NOW()'));
        });

        DB::statement("ALTER TABLE sessions ADD CONSTRAINT sessions_mode_check CHECK (mode IN ('study', 'play'))");
        DB::statement('ALTER TABLE sessions ADD CONSTRAINT sessions_table_number_check CHECK (table_number BETWEEN 1 AND 10)');
        DB::statement('CREATE INDEX idx_sessions_child_id ON sessions (child_id)');
        DB::statement('CREATE INDEX idx_sessions_child_table ON sessions (child_id, table_number)');
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
