<?php

namespace App\Console\Commands;

use App\Http\Controllers\ContractController;
use Illuminate\Console\Command;

class TestPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $con = new ContractController();
        $con->list(1);
    }
}
