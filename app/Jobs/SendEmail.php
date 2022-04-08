<?php

namespace App\Jobs;

use App\Mail\MailCodeForgotPassword;
use App\Mail\MailNewPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $code;
    protected $email;
    protected $new_password;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $code, $new_password)
    {
        $this->email = $email;
        $this->code = $code;
        $this->new_password = $new_password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->code) {
            return Mail::to($this->email)->send(new MailCodeForgotPassword($this->code));
        }
        if($this->new_password) {
            return Mail::to($this->email)->send(new MailNewPassword($this->new_password));
        }
    }
}
