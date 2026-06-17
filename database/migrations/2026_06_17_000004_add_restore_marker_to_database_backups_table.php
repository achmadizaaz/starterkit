<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('database_backups', function (Blueprint $table) {
            if (! Schema::hasColumn('database_backups', 'restored_at')) {
                $table->timestamp('restored_at')->nullable()->after('encrypted_at');
            }

            if (! Schema::hasColumn('database_backups', 'restored_by')) {
                $table->foreignUlid('restored_by')->nullable()->after('restored_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('database_backups', function (Blueprint $table) {
            if (Schema::hasColumn('database_backups', 'restored_by')) {
                $table->dropConstrainedForeignId('restored_by');
            }

            if (Schema::hasColumn('database_backups', 'restored_at')) {
                $table->dropColumn('restored_at');
            }
        });
    }
};
