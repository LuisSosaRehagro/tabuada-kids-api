<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->string('email', 255)->unique();
            $table->string('password_hash', 255);
            $table->string('name', 100);
            $table->timestamp('created_at')->default(DB::raw('NOW()'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_profiles');
    }
};
