<?php

namespace App\Jobs;

use App\Http\Controllers\PaymentController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PayConfirmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $invoice, protected int $payment_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new PaymentController)->postPayConfirm($this->invoice, $this->payment_id);
    }
}
