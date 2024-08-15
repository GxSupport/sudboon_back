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
        Schema::table('check', function (Blueprint $table) {
            $table->string('isInFavor')->nullable()->change();
            $table->string('instance')->nullable()->change();
            $table->string('purpose')->nullable()->change();
            $table->string('purposeId')->nullable()->change();
            $table->string('issued')->nullable()->change();
            $table->string('courtType')->nullable()->change();
            $table->string('balance')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('check', function (Blueprint $table) {
            //
        });
    }
};
