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
        Schema::table('users', function (Blueprint $table) {
            // Add username column to users table
            $table->string('username')->unique()->after('id');
            $table->dropColumn('name'); // Assuming 'name' is not needed anymore
            $table->dropColumn('email'); // Assuming 'email' is not needed anymore
            $table->dropColumn('email_verified_at'); // Assuming 'email_verified_at' is not needed anymore
            $table->dropColumn('remember_token'); // Assuming 'remember_token' is not needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
