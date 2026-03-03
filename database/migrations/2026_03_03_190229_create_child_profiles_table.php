<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('parent_id')->constrained('parent_profiles')->onDelete('cascade');
            $table->string('nickname', 50);
            $table->string('username', 50)->unique();
            $table->string('password_hash', 255);
            $table->timestamp('created_at')->default(DB::raw('NOW()'));
        });

        DB::statement('CREATE INDEX idx_child_profiles_parent ON child_profiles (parent_id)');
    }

    public function down(): void
    {
        Schema::dropIfExists('child_profiles');
    }
};
