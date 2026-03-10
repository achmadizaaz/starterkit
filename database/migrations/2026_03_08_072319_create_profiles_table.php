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
        Schema::create('profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('phone')->nullable();

                $table->enum('gender',['male','female'])->nullable();

                $table->date('birth_date')->nullable();

                $table->text('address')->nullable();

                $table->string('province')->nullable();
                $table->string('city')->nullable();
                $table->string('district')->nullable();
                $table->string('village')->nullable();

                $table->text('bio')->nullable();

                $table->string('website')->nullable();

                $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
