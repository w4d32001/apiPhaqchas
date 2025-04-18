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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->char('dni', 8)->unique()->nullable();
            $table->char('phone', 9)->unique();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->date('birth_date')->nullable();
            $table->integer('faults')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
