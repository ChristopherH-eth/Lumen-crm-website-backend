<?php

namespace App\Jobs;

use App\Models\Cryptocurrency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Facades\Http;

class UpdateCrypto implements ShouldQueue
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Cryptocurrency $cryptocurrency)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        //
    }
}
