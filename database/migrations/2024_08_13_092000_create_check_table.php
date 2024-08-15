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
        Schema::create('check', function (Blueprint $table) {
            $table->id();
            $table->string('invoiceStatus');
            $table->string('paidAmount');
            $table->string('mustPayAmount');
            $table->string('number');
            $table->string('overdue');
            $table->string('payCategory');
            $table->string('payCategoryId');
            $table->string('court');
            $table->string('courtId');
            $table->string('courtOwnId');
            $table->string('forAccount');
            $table->string('amount');
            $table->string('claimCaseNumber')->nullable();
            $table->string('decisionDate')->nullable();
            $table->string('payer')->nullable();
            $table->string('payerId')->nullable();
            $table->string('payerTin')->nullable();
            $table->string('payerPassport')->nullable();
            $table->string('description')->nullable();
            $table->string('isInFavor');
            $table->string('instance');
            $table->string('purpose');
            $table->string('purposeId');
            $table->string('issued');
            $table->string('courtType');
            $table->string('balance');
            $table->tinyInteger('is_active')->default(1);
            $table->integer('contract_id');
            $table->enum('payed', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check');
    }
};
