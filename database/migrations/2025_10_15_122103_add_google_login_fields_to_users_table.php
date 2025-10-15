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
            // Google unikaalne id
            $table->string('google_sub')->nullable()->unique();

            //Audit: viimase logimise variant (google, local), millal logitud
            $table->string('last_login_method', 20)->nullable();
            $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_sub', 'last_login_method', 'last_login_at']);
        });
    }
};
