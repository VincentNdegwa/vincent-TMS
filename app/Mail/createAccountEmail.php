<?php

namespace App\Mail;

use App\Models\userVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class createAccountEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $verificationLink;
    public $email;
    public function __construct($name, $email)
    {
        $verification = userVerification::where("userEmail", $email)->first();
        if ($verification) {
            $verification->update([
                'verificationToken' => Str::random(32)
            ]);
            $this->name = $name;
            $this->verificationLink = env("APP_URL") . "/verify_email/" . $this->name . "/" . $verification->verificationToken;
        } else {
            $verificationLink = env("APP_URL");
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('createAccountEmail');
    }
}
