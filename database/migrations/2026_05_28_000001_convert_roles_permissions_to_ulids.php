<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign keys first if they exist
        try {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                $table->dropForeign('role_has_permissions_permission_id_foreign');
                $table->dropForeign('role_has_permissions_role_id_foreign');
            });
        } catch (\Exception $e) {
            // Foreign keys might not exist
        }

        try {
            Schema::table('model_has_roles', function (Blueprint $table) {
                $table->dropForeign('model_has_roles_role_id_foreign');
            });
        } catch (\Exception $e) {
            // Foreign keys might not exist
        }

        try {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                $table->dropForeign('model_has_permissions_permission_id_foreign');
            });
        } catch (\Exception $e) {
            // Foreign keys might not exist
        }

        // Convert roles table
        Schema::table('roles', function (Blueprint $table) {
            if (Schema::hasColumn('roles', 'name')) {
                try {
                    $table->dropUnique(['name', 'guard_name']);
                } catch (\Exception $e) {
                    // Index might not exist
                }
            }
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('id');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->ulid('id')->primary()->first();
            $table->unique(['name', 'guard_name']);
        });

        // Convert permissions table
        Schema::table('permissions', function (Blueprint $table) {
            if (Schema::hasColumn('permissions', 'name')) {
                try {
                    $table->dropUnique(['name', 'guard_name']);
                } catch (\Exception $e) {
                    // Index might not exist
                }
            }
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('id');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->ulid('id')->primary()->first();
            $table->unique(['name', 'guard_name']);
        });

        // Convert role_has_permissions pivot table
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->dropPrimary();
            $table->string('role_id')->change();
            $table->string('permission_id')->change();
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->cascadeOnDelete();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->cascadeOnDelete();
        });

        // Convert model_has_roles pivot table
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->string('role_id')->change();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->cascadeOnDelete();
        });

        // Convert model_has_permissions pivot table
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->string('permission_id')->change();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Reverse is too complex with data changes
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};


