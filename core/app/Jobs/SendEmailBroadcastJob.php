<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailBroadcastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $to, $name, $subject, $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $name, $subject, $message)
    {
        $this->to = $to;
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        send_email($this->to, $this->name, $this->subject, $this->message);
        // echo "ASD";
    }
}
