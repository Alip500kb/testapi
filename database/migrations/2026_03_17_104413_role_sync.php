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
        Schema::table('pemains', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('password');

            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemains', function (Blueprint $table) {
            if (Schema::hasColumn('pemains', 'role_id')) {
                $table->dropForeign('pemains_role_id_foreign');
                $table->dropColumn('role_id');
        }
        });

    }
};
