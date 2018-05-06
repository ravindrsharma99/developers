<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\WithdrawRequest;


class WithdrawEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WithdrawRequest $WithdrawRequest)
    {
        $this->withdrawRequest = $WithdrawRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->withdrawRequest->status == 'processing'){
            $subject = "Your withdraw request {$this->withdrawRequest->code} is in processing.";
        }
        else if($this->withdrawRequest->status == 'failed'){
            $subject = "Your withdraw request {$this->withdrawRequest->code} is failed.";
        }
        else if($this->withdrawRequest->status == 'success'){
            $subject = "Your withdraw request {$this->withdrawRequest->code} is successful.";
        }
        else{
            $subject = "We received your withdraw request {$this->withdrawRequest->code}.";
        }

        return $this
        ->subject($subject)
        ->view("mails.withdraw.{$this->withdrawRequest->status}");
    }
}
