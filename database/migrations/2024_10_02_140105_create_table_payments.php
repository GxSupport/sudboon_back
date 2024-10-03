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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id')->nullable();
            $table->string('amount');
            $table->enum('status', ['0','1','2'])->default(0)->comment('0 - ожидание, 1 - успешно, 2 - отменено');
            $table->enum('is_payed', ['0','1'])->default(0)->comment('0 - не оплачено, 1 - оплачено');
            $table->string('payment_id')->nullable();
            $table->string('payment_number')->nullable();
            $table->longText('response')->nullable();
            $table->string('response_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
