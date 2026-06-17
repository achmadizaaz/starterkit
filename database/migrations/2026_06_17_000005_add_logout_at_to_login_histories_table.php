<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('login_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('login_histories', 'logout_at')) {
                $table->timestamp('logout_at')->nullable()->after('login_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('login_histories', function (Blueprint $table) {
            if (Schema::hasColumn('login_histories', 'logout_at')) {
                $table->dropColumn('logout_at');
            }
        });
    }
};
