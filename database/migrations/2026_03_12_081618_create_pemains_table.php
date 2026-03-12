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
        Schema::create('pemains', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('username');
            $table->string('password');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('delete_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemains');
    }
};
