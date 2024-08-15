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
        Schema::create('client_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->float('amount',16,2);
            $table->string('number')->nullable();
            $table->string('contract_id');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->boolean('is_active');
            $table->string('courtTypeId')->nullable();
            $table->string('regionId')->nullable();
            $table->string('courtRegionId')->nullable();
            $table->string('purposeId')->nullable();
            $table->string('payCategoryId')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
