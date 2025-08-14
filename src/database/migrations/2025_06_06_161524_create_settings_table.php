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
        Schema::create('settings', function (Blueprint $table) {
            basic_fields($table, 'settings');
            $table->string('key')->unique()->index();
            $table->string('label');
            $table->text('value')->nullable();
            $table->json('attributes')->nullable();
            $table->string('type');
        });

        if (!Schema::hasColumn('settings', 'status')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('status')->default('editable')->after('type')->comment('Status of the setting, e.g., editable, locked (can view but cannot edit), hidden (internal use only)');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
