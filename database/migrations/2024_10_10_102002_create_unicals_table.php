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
        Schema::create('unicals', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('contract')->nullable();
            $table->string('invoice')->nullable();
            $table->enum('payment_status', ['created'])->default(null)->nullable();
            $table->enum('pay_status', ['paid','waiting','failed'])->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unicals');
    }
};
