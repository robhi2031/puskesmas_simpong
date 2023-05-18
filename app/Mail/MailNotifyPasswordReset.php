<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotifyPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bp2tdmempawah.noreply@gmail.com', 'noreply - '.$this->data["siteInfo"]->short_name)
            ->subject($this->data["subject"])
            ->view('mail_templated.password_reset')->with("data", $this->data);
    }
}
