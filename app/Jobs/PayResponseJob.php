<?php

namespace App\Jobs;

use App\Http\Controllers\PaymentController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PayResponseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected int $invoice, protected string $stage)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new PaymentController)->oneCResponsePay($this->invoice, $this->stage);
    }
}
