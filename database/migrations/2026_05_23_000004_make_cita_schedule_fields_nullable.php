<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE citas MODIFY especialista_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE citas MODIFY fecha DATE NULL');
        DB::statement('ALTER TABLE citas MODIFY hora TIME NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE citas MODIFY especialista_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE citas MODIFY fecha DATE NOT NULL');
        DB::statement('ALTER TABLE citas MODIFY hora TIME NOT NULL');
    }
};
