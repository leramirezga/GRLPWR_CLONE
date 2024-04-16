<?php

namespace App\Jobs;

use App\DTO\ExpirationInfo;
use App\Http\Services\SendMessageInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageToRenewPlan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public ExpirationInfo $expirationInfo)
    {}


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendMessageInterface $sender)
    {
        $sender->sendMessage($this->expirationInfo);
    }
}
