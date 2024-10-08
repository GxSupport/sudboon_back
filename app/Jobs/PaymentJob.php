<?php

namespace App\Jobs;

use App\Http\Controllers\PaymentController;
use App\Sevices\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $item, protected int $payment_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new PaymentController())->createPayment($this->item, $this->payment_id);
    }
}
