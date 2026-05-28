<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->ulid('permission_group_id')->nullable()->after('guard_name');
            $table->foreign('permission_group_id')
                ->references('id')
                ->on('permission_groups')
                ->nullableOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['permission_group_id']);
            $table->dropColumn('permission_group_id');
        });
    }
};
