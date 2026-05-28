<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Roles table already has ULID id, just ensure it's a primary key
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'id')) {
                $table->primary('id')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropPrimary();
        });
    }
};
